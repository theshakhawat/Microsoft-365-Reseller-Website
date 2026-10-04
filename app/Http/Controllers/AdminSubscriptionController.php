<?php

namespace App\Http\Controllers;

use App\Jobs\SendSubscriptionStatusEmailJob;
use App\Models\PricingPlan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminSubscriptionController extends Controller
{
    /**
     * Display a listing of customer subscriptions.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with(['user', 'pricingPlan', 'order'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('plan_name', 'like', "%{$search}%")
                  ->orWhere('license_email', 'like', "%{$search}%")
                  ->orWhere('subscription_key', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $subscriptions = $query->paginate(15)->withQueryString();

        $counts = [
            'all'       => Subscription::count(),
            'active'    => Subscription::where('status', 'active')->count(),
            'suspended' => Subscription::where('status', 'suspended')->count(),
            'expired'   => Subscription::where('status', 'expired')->orWhere(function ($q) {
                $q->where('status', 'active')->whereNotNull('expires_at')->where('expires_at', '<', now());
            })->count(),
            'inactive'  => Subscription::where('status', 'inactive')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'counts'));
    }

    /**
     * Show form for manually creating a subscription.
     */
    public function create(): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $plans = PricingPlan::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.subscriptions.create', compact('users', 'plans'));
    }

    /**
     * Store a manually created subscription in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id'         => ['required', 'exists:users,id'],
            'pricing_plan_id' => ['nullable', 'exists:pricing_plans,id'],
            'plan_name'       => ['required', 'string', 'max:255'],
            'license_email'   => ['required', 'email', 'max:255'],
            'starts_at'       => ['required', 'date'],
            'expires_at'      => ['required', 'date', 'after:starts_at'],
            'status'          => ['required', 'in:active,suspended,expired,inactive'],
            'cloud_storage'   => ['nullable', 'string', 'max:255'],
            'admin_notes'     => ['nullable', 'string', 'max:1000'],
        ]);

        $plan = $request->pricing_plan_id ? PricingPlan::find($request->pricing_plan_id) : null;

        $existingSub = Subscription::where('user_id', $request->user_id)->first();

        if ($existingSub) {
            $existingSub->update([
                'pricing_plan_id'  => $request->pricing_plan_id,
                'plan_name'        => $request->plan_name,
                'license_email'    => $request->license_email,
                'starts_at'        => $request->starts_at,
                'expires_at'       => $request->expires_at,
                'status'           => $request->status,
                'cloud_storage'    => $request->cloud_storage ?: '1 TB OneDrive Cloud Storage',
                'included_apps'    => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                'admin_notes'      => $request->admin_notes ?: 'Provisioned and updated by Super Admin.',
            ]);

            return redirect()->route('admin.subscriptions.index')->with('success', 'Customer subscription updated successfully!');
        }

        Subscription::create([
            'user_id'          => $request->user_id,
            'pricing_plan_id'  => $request->pricing_plan_id,
            'plan_name'        => $request->plan_name,
            'license_email'    => $request->license_email,
            'subscription_key' => 'M365-' . strtoupper(uniqid()) . '-MANUAL',
            'starts_at'        => $request->starts_at,
            'expires_at'       => $request->expires_at,
            'status'           => $request->status,
            'cloud_storage'    => $request->cloud_storage ?: '1 TB OneDrive Cloud Storage',
            'included_apps'    => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
            'admin_notes'      => $request->admin_notes ?: 'Manually provisioned by Super Admin.',
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription created and assigned to customer successfully!');
    }

    /**
     * Show form for editing / managing subscription.
     */
    public function edit(Subscription $subscription): View
    {
        $subscription->load(['user', 'pricingPlan']);
        $users = User::where('role', 'user')->orderBy('name')->get();
        $plans = PricingPlan::all();

        return view('admin.subscriptions.edit', compact('subscription', 'users', 'plans'));
    }

    /**
     * Update subscription details (extend, change license email, apps, notes).
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $request->validate([
            'plan_name'     => ['required', 'string', 'max:255'],
            'license_email' => ['required', 'email', 'max:255'],
            'starts_at'     => ['required', 'date'],
            'expires_at'    => ['required', 'date', 'after:starts_at'],
            'status'        => ['required', 'in:active,suspended,expired,inactive'],
            'cloud_storage' => ['nullable', 'string', 'max:255'],
            'admin_notes'   => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $subscription->status;

        $subscription->update([
            'plan_name'     => $request->plan_name,
            'license_email' => $request->license_email,
            'starts_at'     => $request->starts_at,
            'expires_at'    => $request->expires_at,
            'status'        => $request->status,
            'cloud_storage' => $request->cloud_storage ?: $subscription->cloud_storage,
            'admin_notes'   => $request->admin_notes,
        ]);

        // If status changed or notes updated, dispatch email notification
        if ($oldStatus !== $request->status) {
            \App\Models\AppNotification::send([
                'user_id'     => $subscription->user_id,
                'target_role' => 'user',
                'title'       => "Subscription Status: " . ucfirst($request->status),
                'message'     => "Your {$subscription->plan_name} subscription status was updated to " . ucfirst($request->status) . ".",
                'type'        => 'subscription',
                'action_url'  => route('user.subscriptions'),
                'icon'        => $request->status === 'active' ? 'fa-solid fa-circle-check' : 'fa-solid fa-triangle-exclamation',
                'color'       => $request->status === 'active' ? 'emerald' : ($request->status === 'suspended' ? 'rose' : 'amber'),
            ]);

            try {
                SendSubscriptionStatusEmailJob::dispatch($subscription->fresh(), $request->status, $request->admin_notes);
            } catch (\Throwable $e) {
                Log::error("Error queueing subscription status email: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription license updated successfully!');
    }

    /**
     * Quick status update (active, suspended, inactive).
     */
    public function updateStatus(Request $request, Subscription $subscription): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,suspended,expired,inactive'],
        ]);

        $oldStatus = $subscription->status;
        $subscription->update(['status' => $request->status]);

        if ($oldStatus !== $request->status) {
            \App\Models\AppNotification::send([
                'user_id'     => $subscription->user_id,
                'target_role' => 'user',
                'title'       => "Subscription Status: " . ucfirst($request->status),
                'message'     => "Your {$subscription->plan_name} subscription status is now " . ucfirst($request->status) . ".",
                'type'        => 'subscription',
                'action_url'  => route('user.subscriptions'),
                'icon'        => $request->status === 'active' ? 'fa-solid fa-circle-check' : 'fa-solid fa-triangle-exclamation',
                'color'       => $request->status === 'active' ? 'emerald' : ($request->status === 'suspended' ? 'rose' : 'amber'),
            ]);

            try {
                SendSubscriptionStatusEmailJob::dispatch($subscription->fresh(), $request->status);
            } catch (\Throwable $e) {
                Log::error("Error queueing subscription status email: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Subscription status updated to "' . ucfirst($request->status) . '" and customer notified.');
    }

    /**
     * Extend subscription validity by X months / 1 year.
     */
    public function extend(Request $request, Subscription $subscription): RedirectResponse
    {
        $months = (int) ($request->months ?: 12);
        $currentExpiry = ($subscription->expires_at && $subscription->expires_at->isFuture()) 
            ? $subscription->expires_at 
            : now();

        $newExpiry = $currentExpiry->copy()->addMonths($months);

        $subscription->update([
            'expires_at' => $newExpiry,
            'status'     => 'active',
        ]);

        \App\Models\AppNotification::send([
            'user_id'     => $subscription->user_id,
            'target_role' => 'user',
            'title'       => "Subscription Extended! 🎉",
            'message'     => "Your {$subscription->plan_name} subscription has been extended by {$months} months (New Expiry: " . $newExpiry->format('M d, Y') . ").",
            'type'        => 'subscription',
            'action_url'  => route('user.subscriptions'),
            'icon'        => 'fa-solid fa-calendar-check',
            'color'       => 'emerald',
        ]);

        try {
            SendSubscriptionStatusEmailJob::dispatch($subscription->fresh(), 'active', "Validity extended by {$months} months. New expiry date: " . $newExpiry->format('M d, Y'));
        } catch (\Throwable $e) {
            Log::error("Error queueing subscription extension email: " . $e->getMessage());
        }

        return back()->with('success', 'Subscription for ' . $subscription->license_email . ' extended by ' . $months . ' months (New expiry: ' . $newExpiry->format('M d, Y') . ').');
    }

    /**
     * Delete subscription.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription record deleted.');
    }
}
