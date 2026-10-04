<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class UserTicketController extends Controller
{
    /**
     * Display a listing of user's tickets
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = Ticket::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest('updated_at')->paginate(10)->withQueryString();

        $stats = [
            'total'    => Ticket::where('user_id', $user->id)->count(),
            'open'     => Ticket::where('user_id', $user->id)->whereIn('status', ['open', 'in_progress', 'customer_reply'])->count(),
            'answered' => Ticket::where('user_id', $user->id)->where('status', 'answered')->count(),
            'closed'   => Ticket::where('user_id', $user->id)->where('status', 'closed')->count(),
        ];

        return view('user.tickets.index', compact('user', 'tickets', 'stats'));
    }

    /**
     * Show form to create a new ticket
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('user.tickets.create', compact('user'));
    }

    /**
     * Store a newly created ticket
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject'    => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'in:General Support,Billing & Payments,License & Activation,Technical Issue'],
            'priority'   => ['required', 'in:low,medium,high,urgent'],
            'message'    => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf,zip,doc,docx', 'max:5120'], // Max 5MB
        ]);

        $user = Auth::user();
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'ticket_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/tickets');

            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }

            $file->move($destination, $filename);
            $attachmentPath = 'uploads/tickets/' . $filename;
        }

        // Generate unique readable ticket number
        $ticketNumber = 'TICK-' . strtoupper(substr(uniqid(), 7, 6));

        $ticket = Ticket::create([
            'ticket_number'    => $ticketNumber,
            'user_id'          => $user->id,
            'subject'          => $request->subject,
            'department'       => $request->department,
            'priority'         => $request->priority,
            'status'           => 'open',
            'message'          => $request->message,
            'attachment'       => $attachmentPath,
            'last_reply_at'    => now(),
            'is_read_by_admin' => false,
            'is_read_by_user'  => true,
        ]);

        // Send App Notification to Admins
        \App\Models\AppNotification::send([
            'user_id'     => null,
            'target_role' => 'admin',
            'title'       => "New Support Ticket: #{$ticket->ticket_number}",
            'message'     => "{$user->name} opened a ticket regarding '{$ticket->subject}' ({$ticket->department}).",
            'type'        => 'ticket',
            'action_url'  => route('admin.tickets.show', $ticket->id, false),
            'icon'        => 'fa-solid fa-headset',
            'color'       => $ticket->priority === 'urgent' ? 'rose' : 'blue',
        ]);

        // Send App Notification to Customer
        \App\Models\AppNotification::send([
            'user_id'     => $user->id,
            'target_role' => 'user',
            'title'       => "Ticket Created: #{$ticket->ticket_number}",
            'message'     => "Your support ticket '{$ticket->subject}' has been submitted. Our team will assist you soon.",
            'type'        => 'ticket',
            'action_url'  => route('user.tickets.show', $ticket->id, false),
            'icon'        => 'fa-solid fa-headset',
            'color'       => 'blue',
        ]);

        return redirect()->route('user.tickets.show', $ticket->id)
            ->with('success', "Support Ticket #{$ticket->ticket_number} created successfully! Our team will respond shortly.");
    }

    /**
     * Show a ticket discussion
     */
    public function show(Ticket $ticket): View
    {
        $user = Auth::user();

        // Ensure user owns ticket
        if ($ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this support ticket.');
        }

        // Mark as read by user
        if (!$ticket->is_read_by_user) {
            $ticket->update(['is_read_by_user' => true]);
        }

        $ticket->load(['replies.user', 'user']);

        return view('user.tickets.show', compact('user', 'ticket'));
    }

    /**
     * Reply to a ticket as user
     */
    public function reply(Request $request, Ticket $ticket): RedirectResponse
    {
        $user = Auth::user();

        if ($ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'This ticket is closed. Please open a new ticket if you still need assistance.');
        }

        $request->validate([
            'message'    => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf,zip,doc,docx', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = 'reply_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/tickets');

            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }

            $file->move($destination, $filename);
            $attachmentPath = 'uploads/tickets/' . $filename;
        }

        TicketReply::create([
            'ticket_id'      => $ticket->id,
            'user_id'        => $user->id,
            'message'        => $request->message,
            'attachment'     => $attachmentPath,
            'is_admin_reply' => false,
        ]);

        $ticket->update([
            'status'           => 'customer_reply',
            'last_reply_at'    => now(),
            'is_read_by_admin' => false,
            'is_read_by_user'  => true,
        ]);

        // Send App Notification to Admins
        \App\Models\AppNotification::send([
            'user_id'     => null,
            'target_role' => 'admin',
            'title'       => "Customer Reply: Ticket #{$ticket->ticket_number}",
            'message'     => "Customer {$user->name} posted a reply on '{$ticket->subject}'.",
            'type'        => 'ticket',
            'action_url'  => route('admin.tickets.show', $ticket->id),
            'icon'        => 'fa-solid fa-headset',
            'color'       => 'amber',
        ]);

        return back()->with('success', 'Your reply has been posted successfully!');
    }

    /**
     * Close a ticket as user
     */
    public function close(Ticket $ticket): RedirectResponse
    {
        $user = Auth::user();

        if ($ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $ticket->update([
            'status' => 'closed',
        ]);

        return back()->with('success', "Ticket #{$ticket->ticket_number} marked as closed.");
    }
}
