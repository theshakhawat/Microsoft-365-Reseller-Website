<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the profile edit page with image preview.
     */
    public function profile(): View
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile information & photo.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Remove old photo if exists
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $file->move($destinationPath, $filename);
            $user->photo = 'uploads/profile/' . $filename;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the dedicated change password page.
     */
    public function changePassword(): View
    {
        $user = Auth::user();

        return view('user.change-password', compact('user'));
    }

    /**
     * Update user password with secure validation.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        // Prevent setting identical password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'New password cannot be the same as your current password.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your password has been changed successfully!');
    }

    /**
     * Show available active pricing plans to the customer.
     */
    public function plans(): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->canAccessPlans()) {
            return redirect()->route('user.subscriptions')->with('info', 'You already have an active Microsoft 365 Personal subscription. You can order a new plan once your current subscription expires.');
        }

        $plans = PricingPlan::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('user.plans', compact('user', 'plans'));
    }

    /**
     * Show user's active/historical subscriptions.
     */
    public function subscriptions(): View
    {
        $user = Auth::user();
        $subscriptions = Subscription::where('user_id', $user->id)->with(['pricingPlan', 'order'])->latest()->get();

        return view('user.subscriptions', compact('user', 'subscriptions'));
    }

    /**
     * Show user's placed orders with live status.
     */
    public function orders(): View
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with(['pricingPlan', 'paymentMethod'])->latest()->paginate(10);

        return view('user.orders', compact('user', 'orders'));
    }

    /**
     * Show user's payments and invoices.
     */
    public function payments(): View
    {
        $user = Auth::user();
        $payments = Order::where('user_id', $user->id)->with(['paymentMethod'])->latest()->paginate(10);

        return view('user.payments', compact('user', 'payments'));
    }

    /**
     * View/Print Invoice for an order.
     */
    public function invoice(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $order->load(['user', 'pricingPlan', 'paymentMethod']);

        return view('user.invoice', compact('order'));
    }

    /**
     * Show checkout page for a specific plan or default active plan.
     */
    public function checkout(Request $request, ?PricingPlan $plan = null): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$plan || !$plan->exists) {
            $planId = $request->query('plan_id');
            $plan = PricingPlan::where('id', $planId)->where('is_active', true)->first()
                ?? PricingPlan::where('is_active', true)->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc')->firstOrFail();
        }

        $check = $user->canPurchasePlan($plan);
        if (!$check['allowed']) {
            return redirect()->route('user.subscriptions')->with('error', $check['message']);
        }

        $paymentMethods = PaymentMethod::where('status', true)->orderBy('sort_order', 'asc')->get();

        return view('user.checkout', compact('user', 'plan', 'paymentMethods'));
    }

    /**
     * Validate and calculate coupon discount for the given plan without persistent session storage.
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code'    => ['required', 'string'],
            'plan_id' => ['required', 'exists:pricing_plans,id'],
        ]);

        $code = strtoupper(trim($request->code));
        $plan = PricingPlan::findOrFail($request->plan_id);

        /** @var Coupon|null $coupon */
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code. Please verify and try again.'], 422);
        }

        if (!$coupon->is_active) {
            return response()->json(['success' => false, 'message' => 'This coupon code is currently disabled.'], 422);
        }

        if ($coupon->is_expired) {
            return response()->json(['success' => false, 'message' => 'This coupon code has expired.'], 422);
        }

        if ($coupon->is_upcoming) {
            return response()->json(['success' => false, 'message' => 'This coupon code is not active yet.'], 422);
        }

        if ($coupon->is_exhausted) {
            return response()->json(['success' => false, 'message' => 'This coupon has reached its maximum usage limit.'], 422);
        }

        $orderTotal = $plan->numeric_price;

        if ($coupon->min_order_amount && $orderTotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount for this coupon is ৳' . number_format($coupon->min_order_amount, 2)
            ], 422);
        }

        $discountAmount = $coupon->calculateDiscount($orderTotal);
        $finalTotal = max(0, $orderTotal - $discountAmount);

        if ($finalTotal > 0 && $finalTotal < 10) {
            return response()->json([
                'success' => false,
                'message' => 'After coupon discount, the payable amount cannot be between ৳1 and ৳9 (minimum payable is ৳10, or 100% free with ৳0).'
            ], 422);
        }

        return response()->json([
            'success'         => true,
            'message'         => 'Coupon "' . $coupon->code . '" applied successfully!',
            'coupon'          => [
                'id'              => $coupon->id,
                'code'            => $coupon->code,
                'name'            => $coupon->name,
                'discount_type'   => $coupon->discount_type,
                'discount_value'  => $coupon->discount_value,
                'discount_amount' => $discountAmount,
                'formatted'       => $coupon->formatted_discount,
            ],
            'order_total'     => $orderTotal,
            'discount_amount' => $discountAmount,
            'final_total'     => $finalTotal,
            'is_free'         => ($finalTotal <= 0),
        ]);
    }

    /**
     * Process checkout submission.
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'plan_id'           => ['required', 'exists:pricing_plans,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'contact_name'      => ['nullable', 'string', 'max:255'],
            'contact_email'     => ['required', 'email'],
            'contact_phone'     => ['nullable', 'string', 'max:20'],
            'notes'             => ['nullable', 'string', 'max:500'],
            'coupon_code'       => ['nullable', 'string'],
        ]);

        $plan = PricingPlan::findOrFail($request->plan_id);

        // Validate upgrade/downgrade rules
        $check = $user->canPurchasePlan($plan);
        if (!$check['allowed']) {
            return redirect()->route('user.subscriptions')->with('error', $check['message']);
        }

        if ($plan->price_bdt < 10) {
            return redirect()->back()->with('error', 'The selected plan has an invalid price. Please contact support.');
        }

        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        $appliedCouponCode = trim((string) $request->coupon_code);

        // Calculate discount if coupon code was supplied on submit
        $orderTotal = $plan->numeric_price;
        $discountAmount = 0;
        $appliedCoupon = null;

        if ($appliedCouponCode !== '') {
            $coupon = Coupon::where('code', strtoupper($appliedCouponCode))->first();
            if ($coupon && $coupon->isValid()) {
                $discountAmount = $coupon->calculateDiscount($orderTotal);
                $appliedCoupon = $coupon;
            }
        }

        $payableAmount = max(0, $orderTotal - $discountAmount);

        // Validation: Minimum payable amount must be ৳10 unless 100% free (৳0)
        if ($payableAmount > 0 && $payableAmount < 10) {
            return redirect()->back()->with('error', 'The minimum payable amount for checkout must be at least ৳10 (or 100% free with a valid promo coupon).');
        }

        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // 1. If 100% FREE via Coupon
        if ($payableAmount <= 0) {
            /** @var \App\Models\Order $order */
            $order = Order::create([
                'order_number'        => $orderNumber,
                'user_id'             => $user->id,
                'pricing_plan_id'     => $plan->id,
                'payment_method_id'   => $paymentMethod->id,
                'plan_name'           => $plan->name,
                'payment_method_slug' => $paymentMethod->slug,
                'plan_price'          => $orderTotal,
                'coupon_code'         => $appliedCoupon ? $appliedCoupon->code : ($appliedCouponCode ?: null),
                'discount_amount'     => $discountAmount,
                'payable_amount'      => 0,
                'recipient_name'      => $request->contact_name ?: $user->name,
                'recipient_email'     => $request->contact_email,
                'recipient_phone'     => $request->contact_phone,
                'notes'               => $request->notes ? $request->notes . ' (100% Free Promo Coupon)' : '100% Free Promo Coupon',
                'payment_status'      => 'paid',
                'gateway_txn_id'      => 'FREE-' . ($appliedCoupon ? $appliedCoupon->code : 'PROMO'),
                'paid_at'             => now(),
            ]);

            if ($appliedCoupon) {
                $appliedCoupon->increment('used_count');
            }

            // Provision subscription immediately
            $durationMonths = 12;
            if ($plan && str_contains(strtolower($plan->billing_period), 'month')) {
                $durationMonths = 1;
            }

            $existingActiveSub = Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->latest('expires_at')
                ->first()
                ?? Subscription::where('user_id', $user->id)->latest()->first();

            if ($existingActiveSub) {
                $baseExpiry = ($existingActiveSub->expires_at && $existingActiveSub->expires_at->isFuture())
                    ? $existingActiveSub->expires_at
                    : now();

                $isSamePlan = ($existingActiveSub->pricing_plan_id && $existingActiveSub->pricing_plan_id == $plan->id)
                    || (strtolower(trim($existingActiveSub->plan_name)) === strtolower(trim($plan->name)));

                if ($isSamePlan) {
                    $newExpiry = $baseExpiry->copy()->addMonths($durationMonths);
                    $existingActiveSub->update([
                        'order_id'         => $order->id,
                        'expires_at'       => $newExpiry,
                        'status'           => 'active',
                        'admin_notes'      => ($existingActiveSub->admin_notes ? $existingActiveSub->admin_notes . "\n" : '') . 'Extended validity via 100% Free Promo Coupon (' . ($appliedCoupon ? $appliedCoupon->code : 'FREE') . ').',
                    ]);
                } else {
                    $remainingDays = ($existingActiveSub->expires_at && $existingActiveSub->expires_at->isFuture())
                        ? max(0, (int) now()->diffInDays($existingActiveSub->expires_at, false))
                        : 0;

                    $newExpiry = now()->addMonths($durationMonths)->addDays($remainingDays);

                    $existingActiveSub->update([
                        'pricing_plan_id'  => $plan->id,
                        'order_id'         => $order->id,
                        'plan_name'        => $order->plan_name,
                        'license_email'    => $order->recipient_email ?: $user->email,
                        'starts_at'        => now(),
                        'expires_at'       => $newExpiry,
                        'status'           => 'active',
                        'cloud_storage'    => '1 TB OneDrive Cloud Storage',
                        'included_apps'    => $plan->included_apps ?? ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                        'admin_notes'      => ($existingActiveSub->admin_notes ? $existingActiveSub->admin_notes . "\n" : '') . 'Upgraded via 100% Promo Coupon with ' . $remainingDays . ' remaining days carried over.',
                    ]);
                }

                Subscription::where('user_id', $user->id)->where('id', '!=', $existingActiveSub->id)->delete();
            } else {
                $expiresAt = now()->addMonths($durationMonths);

                Subscription::create([
                    'user_id'          => $user->id,
                    'pricing_plan_id'  => $plan->id,
                    'order_id'         => $order->id,
                    'plan_name'        => $order->plan_name,
                    'license_email'    => $order->recipient_email ?: $user->email,
                    'subscription_key' => 'M365-' . strtoupper(uniqid()) . '-BD',
                    'starts_at'        => now(),
                    'expires_at'       => $expiresAt,
                    'status'           => 'active',
                    'cloud_storage'    => '1 TB OneDrive Cloud Storage',
                    'included_apps'    => $plan->included_apps ?? ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                    'admin_notes'      => 'Instant activation via 100% discount coupon (' . ($appliedCoupon ? $appliedCoupon->code : 'FREE') . ').',
                ]);
            }

            // Admin Notification & Alert Email
            \App\Models\AppNotification::send([
                'user_id'     => null,
                'target_role' => 'admin',
                'title'       => "Free Promo Order: #{$order->order_number}",
                'message'     => "{$order->recipient_name} redeemed {$order->plan_name} for free using coupon " . ($appliedCoupon ? $appliedCoupon->code : 'PROMO') . ".",
                'type'        => 'order',
                'action_url'  => route('admin.orders.show', $order->id, false),
                'icon'        => 'fa-solid fa-gift',
                'color'       => 'emerald',
            ]);

            try {
                \App\Jobs\SendOrderPlacedEmailJob::dispatch($order->fresh());
                \App\Jobs\SendPaymentSuccessEmailJob::dispatch($order->fresh());
                \App\Jobs\SendAdminNewOrderAlertJob::dispatch($order->fresh());
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Error dispatching emails for free order #{$order->order_number}: " . $e->getMessage());
            }

            return redirect()->route('user.subscriptions')->with('success', "Congratulations! 100% Free Promo Coupon applied. Your order #{$order->order_number} has been activated successfully!");
        }

        // 2. Regular Order (Payable Amount >= ৳10)
        /** @var \App\Models\Order $order */
        $order = Order::create([
            'order_number'        => $orderNumber,
            'user_id'             => $user->id,
            'pricing_plan_id'     => $plan->id,
            'payment_method_id'   => $paymentMethod->id,
            'plan_name'           => $plan->name,
            'payment_method_slug' => $paymentMethod->slug,
            'plan_price'          => $orderTotal,
            'coupon_code'         => $appliedCouponCode ?: null,
            'discount_amount'     => $discountAmount,
            'payable_amount'      => $payableAmount,
            'recipient_name'      => $request->contact_name ?: $user->name,
            'recipient_email'     => $request->contact_email,
            'recipient_phone'     => $request->contact_phone,
            'notes'               => $request->notes,
            'payment_status'      => 'cancelled',
        ]);

        if ($appliedCoupon) {
            $appliedCoupon->increment('used_count');
        }

        // Send App Notification to Admins
        \App\Models\AppNotification::send([
            'user_id'     => null,
            'target_role' => 'admin',
            'title'       => "New Order Placed: #{$order->order_number}",
            'message'     => "{$order->recipient_name} ordered {$order->plan_name} (৳" . number_format($order->payable_amount, 2) . ") via {$paymentMethod->name}.",
            'type'        => 'order',
            'action_url'  => route('admin.orders.show', $order->id, false),
            'icon'        => 'fa-solid fa-cart-shopping',
            'color'       => 'amber',
        ]);

        // Dispatch Order Placed Email to Customer
        try {
            \App\Jobs\SendOrderPlacedEmailJob::dispatch($order->fresh());
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Error dispatching order placed email for #{$order->order_number}: " . $e->getMessage());
        }

        // If payment method is automated gateway Moneybag
        if ($paymentMethod->slug === 'moneybag') {
            return redirect()->route('user.payment.initiate', ['order_number' => $order->order_number]);
        }

        // Place order and redirect user to orders tab with success message
        return redirect()->route('user.orders')->with('success', "Order #{$order->order_number} placed successfully! Your order is currently pending verification.");
    }

    /**
     * Cancel a pending order
     */
    public function cancelOrder(Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'pending') {
            $order->update(['payment_status' => 'cancelled']);
            return redirect()->route('user.orders')->with('info', "Order #{$order->order_number} has been cancelled.");
        }

        return redirect()->route('user.orders')->with('error', 'Only pending orders can be cancelled.');
    }
}
