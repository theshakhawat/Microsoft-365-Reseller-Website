<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display dedicated Notifications Page for Admin
     */
    public function adminIndex(Request $request): View
    {
        $user = Auth::user();
        $query = AppNotification::where(function ($q) {
            $q->where('target_role', 'admin')
              ->orWhereNull('user_id');
        });

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->latest()->paginate(15)->withQueryString();

        $unreadCount = AppNotification::where(function ($q) {
            $q->where('target_role', 'admin')->orWhereNull('user_id');
        })->where('is_read', false)->count();

        $totalCount = AppNotification::where(function ($q) {
            $q->where('target_role', 'admin')->orWhereNull('user_id');
        })->count();

        return view('admin.notifications.index', compact('user', 'notifications', 'unreadCount', 'totalCount'));
    }

    /**
     * Mark single notification as read / unread (Admin)
     */
    public function adminToggleRead(AppNotification $notification): RedirectResponse
    {
        $notification->update([
            'is_read' => !$notification->is_read,
            'read_at' => !$notification->is_read ? now() : null,
        ]);

        $status = $notification->is_read ? 'marked as read' : 'marked as unread';
        return back()->with('success', "Notification {$status}.");
    }

    /**
     * Mark all notifications as read (Admin)
     */
    public function adminMarkAllRead(): RedirectResponse
    {
        AppNotification::where(function ($q) {
            $q->where('target_role', 'admin')->orWhereNull('user_id');
        })->where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a single notification (Admin)
     */
    public function adminDestroy(AppNotification $notification): RedirectResponse
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * Mark single notification as read and redirect to action URL (Admin)
     */
    public function adminReadAndRedirect(AppNotification $notification): RedirectResponse
    {
        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        $targetUrl = $notification->action_url ?: route('admin.notifications.index');
        return redirect()->to($targetUrl);
    }

    /**
     * Delete all notifications (Admin)
     */
    public function adminDeleteAll(): RedirectResponse
    {
        AppNotification::where(function ($q) {
            $q->where('target_role', 'admin')->orWhereNull('user_id');
        })->delete();

        return back()->with('success', 'All notifications cleared successfully.');
    }

    // =========================================================================
    // USER PORTAL NOTIFICATION ACTIONS
    // =========================================================================

    /**
     * Display dedicated Notifications Page for User
     */
    public function userIndex(Request $request): View
    {
        $user = Auth::user();
        $query = AppNotification::where('user_id', $user->id);

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->latest()->paginate(15)->withQueryString();

        $unreadCount = AppNotification::where('user_id', $user->id)->where('is_read', false)->count();
        $totalCount = AppNotification::where('user_id', $user->id)->count();

        return view('user.notifications.index', compact('user', 'notifications', 'unreadCount', 'totalCount'));
    }

    /**
     * Mark single notification as read / unread (User)
     */
    public function userToggleRead(AppNotification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->update([
            'is_read' => !$notification->is_read,
            'read_at' => !$notification->is_read ? now() : null,
        ]);

        $status = $notification->is_read ? 'marked as read' : 'marked as unread';
        return back()->with('success', "Notification {$status}.");
    }

    /**
     * Mark all notifications as read (User)
     */
    public function userMarkAllRead(): RedirectResponse
    {
        AppNotification::where('user_id', Auth::id())->where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a single notification (User)
     */
    public function userDestroy(AppNotification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * Mark single notification as read and redirect to action URL (User)
     */
    public function userReadAndRedirect(AppNotification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        $targetUrl = $notification->action_url ?: route('user.notifications');
        return redirect()->to($targetUrl);
    }

    /**
     * Delete all notifications (User)
     */
    public function userDeleteAll(): RedirectResponse
    {
        AppNotification::where('user_id', Auth::id())->delete();
        return back()->with('success', 'All notifications cleared successfully.');
    }
}
