<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminContactMessageController extends Controller
{
    /**
     * Display a listing of all contact inquiries.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = ContactMessage::latest();

        // Filter by Read Status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Search by keyword
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => ContactMessage::count(),
            'unread'  => ContactMessage::where('is_read', false)->count(),
            'read'    => ContactMessage::where('is_read', true)->count(),
            'today'   => ContactMessage::whereDate('created_at', Carbon::today())->count(),
        ];

        return view('admin.contact-messages.index', compact('user', 'messages', 'stats'));
    }

    /**
     * Display the specified contact message and mark it as read.
     */
    public function show(ContactMessage $contactMessage): View
    {
        $user = Auth::user();

        if (!$contactMessage->is_read) {
            $contactMessage->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return view('admin.contact-messages.show', compact('user', 'contactMessage'));
    }

    /**
     * Toggle read/unread status of the specified message.
     */
    public function toggleRead(ContactMessage $contactMessage): RedirectResponse
    {
        $newStatus = !$contactMessage->is_read;
        $contactMessage->update([
            'is_read' => $newStatus,
            'read_at' => $newStatus ? now() : null,
        ]);

        $statusText = $newStatus ? 'marked as read' : 'marked as unread';
        return redirect()->back()->with('success', "Message from {$contactMessage->name} {$statusText}.");
    }

    /**
     * Mark all unread messages as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        ContactMessage::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()->back()->with('success', 'All unread messages marked as read.');
    }

    /**
     * Update notification email settings for contact inquiries and system alerts.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notification_email' => ['required', 'email', 'max:255'],
        ]);

        \App\Models\SiteSetting::set('admin_notification_email', trim($validated['admin_notification_email']), 'contact');

        return redirect()->back()->with('success', 'Admin notification recipient email updated to ' . $validated['admin_notification_email'] . ' successfully.');
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $name = $contactMessage->name;
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', "Message from {$name} deleted successfully.");
    }
}
