<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderApprovedEmailJob;
use App\Jobs\SendOrderCancelledEmailJob;
use App\Models\Order;
use App\Models\PricingPlan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'pricingPlan', 'paymentMethod'])->latest();

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%")
                  ->orWhere('plan_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'all'       => Order::count(),
            'paid'      => Order::where('payment_status', 'paid')->count(),
            'pending'   => Order::where('payment_status', 'pending')->count(),
            'cancelled' => Order::where('payment_status', 'cancelled')->count(),
            'failed'    => Order::where('payment_status', 'failed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    /**
     * Show order details.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'pricingPlan', 'paymentMethod']);
        $existingSubscription = Subscription::where('order_id', $order->id)->first();

        return view('admin.orders.show', compact('order', 'existingSubscription'));
    }

    /**
     * Approve order and activate/provision subscription for customer.
     */
    public function approve(Request $request, Order $order): RedirectResponse
    {
        // Mark order payment status as paid
        $order->update([
            'payment_status' => 'paid',
            'paid_at'        => $order->paid_at ?? now(),
        ]);

        $plan = $order->pricingPlan;
        $durationMonths = 12; // default annual plan
        if ($plan && str_contains(strtolower($plan->billing_period), 'month')) {
            $durationMonths = 1;
        }

        // Find existing subscription for this user
        $existingSub = Subscription::where('user_id', $order->user_id)
            ->where('status', 'active')
            ->latest('expires_at')
            ->first() 
            ?? Subscription::where('user_id', $order->user_id)->latest()->first();

        if ($existingSub) {
            $baseExpiry = ($existingSub->expires_at && $existingSub->expires_at->isFuture()) 
                ? $existingSub->expires_at 
                : now();

            $isSamePlan = ($existingSub->pricing_plan_id && $existingSub->pricing_plan_id == $order->pricing_plan_id)
                || (strtolower(trim($existingSub->plan_name)) === strtolower(trim($order->plan_name)));

            if ($isSamePlan) {
                // Same Plan: Extend existing validity
                $newExpiry = $baseExpiry->copy()->addMonths($durationMonths);
                $existingSub->update([
                    'order_id'         => $order->id,
                    'pricing_plan_id'  => $order->pricing_plan_id ?: $existingSub->pricing_plan_id,
                    'plan_name'        => $order->plan_name ?: $existingSub->plan_name,
                    'license_email'    => $order->recipient_email ?: $existingSub->license_email ?: $order->user->email,
                    'expires_at'       => $newExpiry,
                    'status'           => 'active',
                    'cloud_storage'    => $existingSub->cloud_storage ?: '1 TB OneDrive Cloud Storage',
                    'included_apps'    => $plan ? $plan->included_apps : $existingSub->included_apps,
                    'admin_notes'      => ($existingSub->admin_notes ? $existingSub->admin_notes . "\n" : '') . "Renewed & validity extended by {$durationMonths} months via Order #{$order->order_number} (New Expiry: " . $newExpiry->format('M d, Y') . ").",
                ]);
            } else {
                // Upgrade Plan: Carry over remaining days and upgrade features
                $remainingDays = ($existingSub->expires_at && $existingSub->expires_at->isFuture())
                    ? max(0, (int) now()->diffInDays($existingSub->expires_at, false))
                    : 0;

                $newExpiry = now()->addMonths($durationMonths)->addDays($remainingDays);

                $existingSub->update([
                    'pricing_plan_id'  => $order->pricing_plan_id,
                    'order_id'         => $order->id,
                    'plan_name'        => $order->plan_name,
                    'license_email'    => $order->recipient_email ?: $existingSub->license_email ?: $order->user->email,
                    'starts_at'        => now(),
                    'expires_at'       => $newExpiry,
                    'status'           => 'active',
                    'cloud_storage'    => '1 TB OneDrive Cloud Storage',
                    'included_apps'    => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                    'admin_notes'      => ($existingSub->admin_notes ? $existingSub->admin_notes . "\n" : '') . "Upgraded to {$order->plan_name} via Order #{$order->order_number} ({$remainingDays} remaining days carried over). Total validity until " . $newExpiry->format('M d, Y') . '.',
                ]);
            }

            // Remove any other duplicate subscriptions for this user to ensure only 1 clean record
            Subscription::where('user_id', $order->user_id)
                ->where('id', '!=', $existingSub->id)
                ->delete();

            $subscription = $existingSub;
        } else {
            // First time subscriber
            $expiresAt = now()->addMonths($durationMonths);

            $subscription = Subscription::create([
                'user_id'          => $order->user_id,
                'pricing_plan_id'  => $order->pricing_plan_id,
                'order_id'         => $order->id,
                'plan_name'        => $order->plan_name,
                'license_email'    => $order->recipient_email ?: $order->user->email,
                'subscription_key' => 'M365-' . strtoupper(uniqid()) . '-BD',
                'starts_at'        => now(),
                'expires_at'       => $expiresAt,
                'status'           => 'active',
                'cloud_storage'    => '1 TB OneDrive Cloud Storage',
                'included_apps'    => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                'admin_notes'      => 'Approved and provisioned upon Order #' . $order->order_number . ' verification.',
            ]);
        }

        // Send In-App Notification to Customer
        \App\Models\AppNotification::send([
            'user_id'     => $order->user_id,
            'target_role' => 'user',
            'title'       => "Order #{$order->order_number} Approved! 🎉",
            'message'     => "Your Microsoft 365 {$order->plan_name} license is active until " . $subscription->expires_at->format('M d, Y') . '.',
            'type'        => 'subscription',
            'action_url'  => route('user.subscriptions'),
            'icon'        => 'fa-solid fa-shield-halved',
            'color'       => 'emerald',
        ]);

        // Dispatch queued email to customer
        try {
            SendOrderApprovedEmailJob::dispatch($order->fresh());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Error queueing order approved email: " . $e->getMessage());
        }

        return back()->with('success', 'Order #' . $order->order_number . ' approved! Subscription license validity updated for customer ' . $order->user->name . '.');
    }

    /**
     * Cancel / Reject order.
     */
    public function cancel(Request $request, Order $order): RedirectResponse
    {
        $order->update(['payment_status' => 'cancelled']);

        // If subscription exists, suspend it
        Subscription::where('order_id', $order->id)->update(['status' => 'inactive']);

        // Send Notification to Customer
        \App\Models\AppNotification::send([
            'user_id'     => $order->user_id,
            'target_role' => 'user',
            'title'       => "Order #{$order->order_number} Cancelled",
            'message'     => "Your order for {$order->plan_name} has been cancelled. If you believe this is an error, please contact support.",
            'type'        => 'order',
            'action_url'  => route('user.orders'),
            'icon'        => 'fa-solid fa-ban',
            'color'       => 'rose',
        ]);

        try {
            SendOrderCancelledEmailJob::dispatch($order->fresh());
        } catch (\Throwable $e) {
            Log::error("Error queueing order cancelled email: " . $e->getMessage());
        }

        return back()->with('success', 'Order #' . $order->order_number . ' marked as cancelled and customer notified.');
    }
}
