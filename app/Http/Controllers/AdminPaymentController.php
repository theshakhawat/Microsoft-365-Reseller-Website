<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderApprovedEmailJob;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\AppNotification;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\PricingPlan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    /**
     * Display listing of all transactions & payments across gateways and manual entries.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'paymentMethod'])->whereNotNull('payment_status');

        if ($request->filled('method')) {
            $query->where('payment_method_slug', $request->method);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('gateway_txn_id', 'like', "%{$search}%")
                  ->orWhere('gateway_txn_number', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        $totalRevenue = Order::where('payment_status', 'paid')->sum('payable_amount');
        $paymentMethods = PaymentMethod::all();

        $counts = [
            'total_revenue' => $totalRevenue,
            'paid_count'    => Order::where('payment_status', 'paid')->count(),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'failed_count'  => Order::whereIn('payment_status', ['failed', 'cancelled'])->count(),
        ];

        return view('admin.payments.index', compact('payments', 'paymentMethods', 'counts'));
    }

    /**
     * Show the form to record a new manual / office walk-in payment.
     */
    public function create(): View
    {
        $users = User::where('role', 'user')->orderBy('name')->get(['id', 'name', 'email', 'phone']);
        $pricingPlans = PricingPlan::where('is_active', true)->orderBy('sort_order')->get();
        $paymentMethods = PaymentMethod::where('status', true)->get();

        return view('admin.payments.create', compact('users', 'pricingPlans', 'paymentMethods'));
    }

    /**
     * Store a manual / office payment and optionally provision or renew user's subscription.
     */
    public function storeManual(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_type'         => 'required|in:existing,new',
            'user_id'               => 'required_if:customer_type,existing|nullable|exists:users,id',
            'new_user_name'         => 'required_if:customer_type,new|nullable|string|max:255',
            'new_user_email'        => 'required_if:customer_type,new|nullable|email|max:255|unique:users,email',
            'new_user_phone'        => 'nullable|string|max:50',
            'new_user_password'     => 'nullable|string|min:6',
            'pricing_plan_id'       => 'nullable|exists:pricing_plans,id',
            'plan_name'             => 'required|string|max:255',
            'plan_price'            => 'required|numeric|min:0',
            'discount_amount'       => 'nullable|numeric|min:0',
            'payable_amount'        => 'required|numeric|min:0',
            'payment_method_slug'   => 'required|string|max:50',
            'gateway_txn_id'        => 'nullable|string|max:100',
            'gateway_txn_number'    => 'nullable|string|max:100',
            'paid_at'               => 'nullable|date',
            'recipient_name'        => 'nullable|string|max:255',
            'recipient_email'       => 'required|email|max:255',
            'recipient_phone'       => 'nullable|string|max:50',
            'notes'                 => 'nullable|string|max:1000',
            'activate_subscription' => 'nullable|boolean',
            'duration_months'       => 'nullable|integer|min:1|max:120',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Resolve or Create User
            if ($request->customer_type === 'new') {
                $rawPassword = $request->filled('new_user_password') ? $request->new_user_password : Str::random(10);
                $user = User::create([
                    'name'                       => $request->new_user_name,
                    'email'                      => $request->new_user_email,
                    'phone'                      => $request->new_user_phone,
                    'password'                   => Hash::make($rawPassword),
                    'role'                       => 'user',
                    'status'                     => true,
                    'push_notifications_enabled' => true,
                ]);

                // Dispatch Welcome Email to new customer
                try {
                    SendWelcomeEmailJob::dispatch($user, $rawPassword);
                } catch (\Throwable $e) {
                    Log::error("Error dispatching welcome email for new manual customer: " . $e->getMessage());
                }

                // Send In-App Welcome Notification
                AppNotification::send([
                    'user_id'     => $user->id,
                    'target_role' => 'user',
                    'title'       => 'Welcome to Microsoft Office Club! 🎉',
                    'message'     => 'Your account has been created by administration along with your direct office payment.',
                    'type'        => 'user',
                    'action_url'  => route('user.dashboard'),
                    'icon'        => 'fa-solid fa-user-check',
                    'color'       => 'emerald',
                ]);
            } else {
                $user = User::findOrFail($request->user_id);
            }

            // 2. Resolve Pricing Plan
            $plan = null;
            if ($request->filled('pricing_plan_id')) {
                $plan = PricingPlan::find($request->pricing_plan_id);
            }

            // 3. Resolve Payment Method
            $paymentMethod = PaymentMethod::where('slug', $request->payment_method_slug)->first();
            if (!$paymentMethod && $request->payment_method_slug === 'office_cash') {
                $paymentMethod = PaymentMethod::firstOrCreate(
                    ['slug' => 'office_cash'],
                    [
                        'name'        => 'Cash / Office Walk-in',
                        'instruction' => 'Direct cash payment received at physical office desk.',
                        'mode'        => 'live',
                        'status'      => true,
                        'sort_order'  => 99,
                    ]
                );
            }

            // 4. Generate Unique Order Number
            $orderNumber = 'ORD-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);
            while (Order::where('order_number', $orderNumber)->exists()) {
                $orderNumber = 'ORD-' . strtoupper(Str::random(4)) . '-' . rand(1000, 9999);
            }

            $paidAt = $request->filled('paid_at') ? Carbon::parse($request->paid_at) : now();
            $txnId = $request->filled('gateway_txn_id') 
                ? $request->gateway_txn_id 
                : ('OFFICE-REC-' . strtoupper(Str::random(6)));

            // 5. Create Order Record
            $order = Order::create([
                'order_number'        => $orderNumber,
                'user_id'             => $user->id,
                'pricing_plan_id'     => $plan ? $plan->id : null,
                'payment_method_id'   => $paymentMethod ? $paymentMethod->id : null,
                'plan_name'           => $request->plan_name,
                'payment_method_slug' => $request->payment_method_slug,
                'plan_price'          => $request->plan_price,
                'coupon_code'         => $request->discount_amount > 0 ? 'OFFICE-DISCOUNT' : null,
                'discount_amount'     => $request->discount_amount ?: 0,
                'payable_amount'      => $request->payable_amount,
                'recipient_name'      => $request->recipient_name ?: $user->name,
                'recipient_email'     => $request->recipient_email ?: $user->email,
                'recipient_phone'     => $request->recipient_phone ?: $user->phone,
                'notes'               => $request->notes ?: 'Manual / Office desk payment received.',
                'payment_status'      => 'paid',
                'gateway_txn_id'      => $txnId,
                'gateway_txn_number'  => $request->gateway_txn_number,
                'gateway_response'    => 'Manual Entry by Admin: ' . auth()->user()->name,
                'paid_at'             => $paidAt,
            ]);

            // 6. Handle Subscription Provisioning (if enabled)
            $durationMonths = (int) ($request->duration_months ?: 12);
            if ($plan && !$request->filled('duration_months')) {
                if (str_contains(strtolower($plan->billing_period), 'month')) {
                    $durationMonths = 1;
                }
            }

            $subscription = null;
            if ($request->boolean('activate_subscription', true)) {
                $existingSub = Subscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->latest('expires_at')
                    ->first() 
                    ?? Subscription::where('user_id', $user->id)->latest()->first();

                if ($existingSub) {
                    $baseExpiry = ($existingSub->expires_at && $existingSub->expires_at->isFuture()) 
                        ? $existingSub->expires_at 
                        : now();

                    $isSamePlan = ($existingSub->pricing_plan_id && $existingSub->pricing_plan_id == $order->pricing_plan_id)
                        || (strtolower(trim($existingSub->plan_name)) === strtolower(trim($order->plan_name)));

                    if ($isSamePlan) {
                        $newExpiry = $baseExpiry->copy()->addMonths($durationMonths);
                        $existingSub->update([
                            'order_id'        => $order->id,
                            'pricing_plan_id' => $order->pricing_plan_id ?: $existingSub->pricing_plan_id,
                            'plan_name'       => $order->plan_name ?: $existingSub->plan_name,
                            'license_email'   => $order->recipient_email ?: $existingSub->license_email ?: $user->email,
                            'expires_at'      => $newExpiry,
                            'status'          => 'active',
                            'cloud_storage'   => $existingSub->cloud_storage ?: '1 TB OneDrive Cloud Storage',
                            'included_apps'   => $plan ? $plan->included_apps : $existingSub->included_apps,
                            'admin_notes'     => ($existingSub->admin_notes ? $existingSub->admin_notes . "\n" : '') . "Renewed via Office Payment Order #{$order->order_number} (+{$durationMonths} months, Expiry: " . $newExpiry->format('M d, Y') . ").",
                        ]);
                    } else {
                        $remainingDays = ($existingSub->expires_at && $existingSub->expires_at->isFuture())
                            ? max(0, (int) now()->diffInDays($existingSub->expires_at, false))
                            : 0;

                        $newExpiry = now()->addMonths($durationMonths)->addDays($remainingDays);
                        $existingSub->update([
                            'pricing_plan_id' => $order->pricing_plan_id,
                            'order_id'        => $order->id,
                            'plan_name'       => $order->plan_name,
                            'license_email'   => $order->recipient_email ?: $existingSub->license_email ?: $user->email,
                            'starts_at'       => now(),
                            'expires_at'      => $newExpiry,
                            'status'          => 'active',
                            'cloud_storage'   => '1 TB OneDrive Cloud Storage',
                            'included_apps'   => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                            'admin_notes'     => ($existingSub->admin_notes ? $existingSub->admin_notes . "\n" : '') . "Upgraded via Office Payment Order #{$order->order_number} ({$remainingDays} remaining days carried over, Expiry: " . $newExpiry->format('M d, Y') . ").",
                        ]);
                    }

                    // Remove duplicate records
                    Subscription::where('user_id', $user->id)
                        ->where('id', '!=', $existingSub->id)
                        ->delete();

                    $subscription = $existingSub;
                } else {
                    $expiresAt = now()->addMonths($durationMonths);
                    $subscription = Subscription::create([
                        'user_id'          => $user->id,
                        'pricing_plan_id'  => $order->pricing_plan_id,
                        'order_id'         => $order->id,
                        'plan_name'        => $order->plan_name,
                        'license_email'    => $order->recipient_email ?: $user->email,
                        'subscription_key' => 'M365-' . strtoupper(uniqid()) . '-BD',
                        'starts_at'        => now(),
                        'expires_at'       => $expiresAt,
                        'status'           => 'active',
                        'cloud_storage'    => '1 TB OneDrive Cloud Storage',
                        'included_apps'    => $plan ? $plan->included_apps : ['word', 'excel', 'powerpoint', 'outlook', 'onedrive', 'copilot'],
                        'admin_notes'      => 'Office manual payment verified and license activated upon Order #' . $order->order_number . '.',
                    ]);
                }
            }

            // 7. Send In-App Notification to Customer
            AppNotification::send([
                'user_id'     => $user->id,
                'target_role' => 'user',
                'title'       => "Payment Received & Order #{$order->order_number} Approved! 🎉",
                'message'     => "Your payment of ৳" . number_format($order->payable_amount, 2) . " has been verified and your Microsoft 365 {$order->plan_name} license is active.",
                'type'        => 'payment',
                'action_url'  => route('user.orders'),
                'icon'        => 'fa-solid fa-receipt',
                'color'       => 'emerald',
            ]);

            // 8. Queue confirmation emails to customer
            try {
                \App\Jobs\SendOrderPlacedEmailJob::dispatch($order->fresh());
                \App\Jobs\SendPaymentSuccessEmailJob::dispatch($order->fresh());
                \App\Jobs\SendOrderApprovedEmailJob::dispatch($order->fresh());
            } catch (\Throwable $e) {
                Log::error("Error queueing manual order emails: " . $e->getMessage());
            }

            return redirect()->route('admin.payments.index')
                ->with('success', "Manual payment of ৳" . number_format($order->payable_amount, 2) . " for Order #{$order->order_number} recorded successfully for {$user->name}!");
        });
    }
}
