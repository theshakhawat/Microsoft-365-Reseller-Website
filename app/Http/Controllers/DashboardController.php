<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function adminDashboard(): View
    {
        $user = Auth::user();

        // 1. Comprehensive Live Metrics
        $totalRevenue = (float) Order::where('payment_status', 'paid')->sum('payable_amount');
        $thisMonthRevenue = (float) Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('payable_amount');
        $todayRevenue = (float) Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('payable_amount');

        $stats = [
            'total_users'        => User::where('role', 'user')->count(),
            'active_licenses'    => Subscription::where('status', 'active')->count(),
            'total_orders'       => Order::count(),
            'pending_orders'     => Order::where('payment_status', 'pending')->count(),
            'paid_orders'        => Order::where('payment_status', 'paid')->count(),
            'total_revenue'      => $totalRevenue,
            'this_month_revenue' => $thisMonthRevenue,
            'today_revenue'      => $todayRevenue,
            'open_tickets'       => \App\Models\Ticket::whereIn('status', ['open', 'in_progress', 'customer_reply'])->count(),
            'unread_messages'    => \App\Models\ContactMessage::where('is_read', false)->count(),
            'active_coupons'     => \App\Models\Coupon::where('is_active', true)->count(),
            'active_gateways'    => \App\Models\PaymentMethod::where('status', true)->count(),
        ];

        // 2. 7-Day Revenue & Orders Trend Dataset for Charts
        $days = 7;
        $trendDates = [];
        $revenueTrend = [];
        $ordersTrend = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $trendDates[] = $date->format('M d');

            $dayRevenue = (float) Order::where('payment_status', 'paid')
                ->whereDate('created_at', $dateStr)
                ->sum('payable_amount');
            $revenueTrend[] = $dayRevenue;

            $dayOrders = Order::whereDate('created_at', $dateStr)->count();
            $ordersTrend[] = $dayOrders;
        }

        // 3. Payment Method Order Distribution
        $paymentMethods = \App\Models\PaymentMethod::withCount('orders')->get();
        $pmLabels = [];
        $pmSeries = [];
        foreach ($paymentMethods as $pm) {
            $pmLabels[] = $pm->name;
            $pmSeries[] = $pm->orders_count;
        }

        // 4. Plan Active Subscription Distribution
        $plans = \App\Models\PricingPlan::withCount(['subscriptions' => function ($q) {
            $q->where('status', 'active');
        }])->get();
        $planLabels = [];
        $planSeries = [];
        foreach ($plans as $p) {
            $planLabels[] = $p->name;
            $planSeries[] = $p->subscriptions_count;
        }

        // 5. Recent Lists
        $pendingOrders = Order::with(['user', 'paymentMethod'])->where('payment_status', 'pending')->latest()->take(5)->get();
        $recentOrders = Order::with(['user', 'paymentMethod'])->latest()->take(6)->get();
        $recentUsers = User::latest()->take(6)->get();
        $recentTickets = \App\Models\Ticket::with('user')->latest()->take(5)->get();
        $recentMessages = \App\Models\ContactMessage::latest()->take(4)->get();
        $smtpSetting = \App\Models\SmtpSetting::first();

        return view('admin.dashboard', compact(
            'user',
            'stats',
            'trendDates',
            'revenueTrend',
            'ordersTrend',
            'pmLabels',
            'pmSeries',
            'planLabels',
            'planSeries',
            'pendingOrders',
            'recentOrders',
            'recentUsers',
            'recentTickets',
            'recentMessages',
            'smtpSetting'
        ));
    }

    /**
     * Clear application cache, config, views, routes, and link storage.
     */
    public function clearCache(): \Illuminate\Http\RedirectResponse
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');

            // Re-apply database SMTP config
            \App\Models\SmtpSetting::applyConfig();

            // Run storage link safely
            try {
                \Illuminate\Support\Facades\Artisan::call('storage:link');
            } catch (\Throwable $e) {
                // Storage link might already exist
            }

            return back()->with('success', 'System optimized! Cache, config, views, routes cleared and storage link synced successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error clearing system cache: ' . $e->getMessage());
        }
    }

    /**
     * Display the User Dashboard.
     */
    public function userDashboard(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $activeSubscription = $user->activeSubscription();
        $recentOrders = $user->orders()->with('paymentMethod')->latest()->take(5)->get();

        $stats = [
            'active_licenses' => $user->subscriptions()->where('status', 'active')->count(),
            'total_orders'    => $user->orders()->count(),
            'pending_orders'  => $user->orders()->where('payment_status', 'pending')->count(),
            'paid_orders'     => $user->orders()->where('payment_status', 'paid')->count(),
            'total_spent'     => (float) $user->orders()->where('payment_status', 'paid')->sum('payable_amount'),
            'open_tickets'    => \App\Models\Ticket::where('user_id', $user->id)->whereIn('status', ['open', 'in_progress', 'customer_reply'])->count(),
            'unread_notifs'   => \App\Models\AppNotification::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('target_role', 'user');
            })->where('is_read', false)->count(),
        ];

        $recentTickets = \App\Models\Ticket::where('user_id', $user->id)->latest()->take(3)->get();
        
        $recentNotifications = \App\Models\AppNotification::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('target_role', 'user');
        })->latest()->take(4)->get();

        $availablePlans = \App\Models\PricingPlan::where('is_active', true)->orderBy('sort_order', 'asc')->take(3)->get();

        return view('user.dashboard', compact(
            'user',
            'activeSubscription',
            'recentOrders',
            'stats',
            'recentTickets',
            'recentNotifications',
            'availablePlans'
        ));
    }
}
