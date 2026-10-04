<?php

namespace App\Http\Controllers;

use App\Jobs\SendTicketReplyEmailJob;
use App\Jobs\SendTicketUpdatedEmailJob;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of support tickets in Admin Panel
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = Ticket::with(['user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest('updated_at')->paginate(15)->withQueryString();

        $stats = [
            'total'          => Ticket::count(),
            'open'           => Ticket::where('status', 'open')->count(),
            'customer_reply' => Ticket::where('status', 'customer_reply')->count(),
            'answered'       => Ticket::where('status', 'answered')->count(),
            'closed'         => Ticket::where('status', 'closed')->count(),
            'unread'         => Ticket::where('is_read_by_admin', false)->count(),
        ];

        return view('admin.tickets.index', compact('user', 'tickets', 'stats'));
    }

    /**
     * Display ticket conversation and reply form
     */
    public function show(Ticket $ticket): View
    {
        $user = Auth::user();

        // Mark as read by admin
        if (!$ticket->is_read_by_admin) {
            $ticket->update(['is_read_by_admin' => true]);
        }

        $ticket->load(['replies.user', 'user']);

        return view('admin.tickets.show', compact('user', 'ticket'));
    }

    /**
     * Post a reply to the ticket as Admin
     */
    public function reply(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'message'    => ['required', 'string', 'max:5000'],
            'status'     => ['nullable', 'in:open,answered,in_progress,closed'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf,zip,doc,docx', 'max:5120'],
        ]);

        $admin = Auth::user();
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'admin_reply_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/tickets');

            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }

            $file->move($destination, $filename);
            $attachmentPath = 'uploads/tickets/' . $filename;
        }

        $reply = TicketReply::create([
            'ticket_id'      => $ticket->id,
            'user_id'        => $admin->id,
            'message'        => $request->message,
            'attachment'     => $attachmentPath,
            'is_admin_reply' => true,
        ]);

        $newStatus = $request->status ?: 'answered';

        $ticket->update([
            'status'           => $newStatus,
            'last_reply_at'    => now(),
            'is_read_by_admin' => true,
            'is_read_by_user'  => false, // Notify customer of new answer
        ]);

        // Send App Notification to Ticket Owner
        \App\Models\AppNotification::send([
            'user_id'     => $ticket->user_id,
            'target_role' => 'user',
            'title'       => "Support Reply: Ticket #{$ticket->ticket_number}",
            'message'     => "Support staff replied to your ticket '{$ticket->subject}'.",
            'type'        => 'ticket',
            'action_url'  => route('user.tickets.show', $ticket->id),
            'icon'        => 'fa-solid fa-headset',
            'color'       => 'blue',
        ]);

        // Dispatch background email notification to customer
        try {
            SendTicketReplyEmailJob::dispatch($ticket->fresh(), $reply->fresh());
        } catch (\Throwable $e) {
            Log::error("Error dispatching ticket reply email: " . $e->getMessage());
        }

        return back()->with('success', "Reply posted to Ticket #{$ticket->ticket_number} and customer notified via email!");
    }

    /**
     * Update ticket status or priority directly
     */
    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        $request->validate([
            'status'   => ['nullable', 'in:open,answered,customer_reply,in_progress,closed'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
        ]);

        $updates = [];
        if ($request->filled('status')) {
            $updates['status'] = $request->status;
        }
        if ($request->filled('priority')) {
            $updates['priority'] = $request->priority;
        }

        if (!empty($updates)) {
            $ticket->update($updates);

            // Send App Notification to User
            \App\Models\AppNotification::send([
                'user_id'     => $ticket->user_id,
                'target_role' => 'user',
                'title'       => "Ticket Updated: #{$ticket->ticket_number}",
                'message'     => "Your support ticket status/priority was updated to " . strtoupper(str_replace('_', ' ', $ticket->status)) . ".",
                'type'        => 'ticket',
                'action_url'  => route('user.tickets.show', $ticket->id),
                'icon'        => 'fa-solid fa-headset',
                'color'       => 'blue',
            ]);

            // Dispatch background email notification
            try {
                SendTicketUpdatedEmailJob::dispatch($ticket->fresh());
            } catch (\Throwable $e) {
                Log::error("Error dispatching ticket update email: " . $e->getMessage());
            }
        }

        return back()->with('success', "Ticket #{$ticket->ticket_number} updated and customer notified!");
    }

    /**
     * Delete a ticket
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        // Delete attachments if any
        if ($ticket->attachment && File::exists(public_path($ticket->attachment))) {
            File::delete(public_path($ticket->attachment));
        }

        foreach ($ticket->replies as $reply) {
            if ($reply->attachment && File::exists(public_path($reply->attachment))) {
                File::delete(public_path($reply->attachment));
            }
        }

        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', "Ticket #{$ticket->ticket_number} deleted successfully.");
    }
}
