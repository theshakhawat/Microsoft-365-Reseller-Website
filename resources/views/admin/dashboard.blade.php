@extends('layouts.admin.admin')

@section('title', 'Admin Command Center | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6 sm:space-y-8">

    <!-- ================================================================= -->
    <!-- 1. EXECUTIVE WELCOME & QUICK ACTIONS BANNER                       -->
    <!-- ================================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-[#072448] to-[#0067b8] text-white p-6 sm:p-8 shadow-xl">
        <!-- Glow accents -->
        <div class="absolute -right-10 -top-10 w-60 h-60 rounded-full bg-sky-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-10 w-60 h-60 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[11px] font-extrabold uppercase tracking-wider bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-sky-200 border border-white/15 flex items-center gap-1.5">
                        <i class="fa-solid fa-crown text-amber-400 text-xs"></i> Super Administrator
                    </span>
                    <span class="text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 px-2.5 py-0.5 rounded-full flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Gateways Active ({{ $stats['active_gateways'] }})
                    </span>
                    @if($smtpSetting && $smtpSetting->is_active)
                        <span class="text-[11px] font-semibold bg-sky-500/20 text-sky-300 border border-sky-400/30 px-2.5 py-0.5 rounded-full">
                            <i class="fa-solid fa-envelope-circle-check text-[10px] mr-1"></i> SMTP Ready
                        </span>
                    @endif
                </div>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Welcome Back, {{ $user->name }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Real-time monitoring for Microsoft 365 cloud licensing, live payments, revenue volume, and customer support tickets.
                </p>
            </div>

            <!-- Quick Admin Actions -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('admin.plans.create') }}" class="bg-white hover:bg-slate-100 text-slate-900 font-extrabold px-3.5 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                    <i class="fa-solid fa-plus text-[#0067b8]"></i>
                    <span>Add Plan</span>
                </a>
                <a href="{{ route('admin.coupons.create') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold px-3.5 py-2.5 rounded-xl text-xs border border-white/20 flex items-center gap-2 transition-all active:scale-95">
                    <i class="fa-solid fa-ticket text-amber-400"></i>
                    <span>Create Coupon</span>
                </a>
                <a href="{{ route('admin.clear-cache') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-3.5 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95" title="Clear all caches & optimize system">
                    <i class="fa-solid fa-arrows-rotate"></i>
                    <span>Optimize</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 2. PRIMARY 6 KPI METRIC CARDS                                     -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        
        <!-- Stat 1: Total Revenue -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-emerald-400 dark:hover:border-emerald-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Total Revenue</p>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                ৳{{ number_format($stats['total_revenue']) }}
            </p>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold mt-1 flex items-center gap-1">
                <i class="fa-solid fa-circle-check text-[9px]"></i> {{ $stats['paid_orders'] }} Paid Orders
            </p>
        </div>

        <!-- Stat 2: This Month Revenue -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-purple-400 dark:hover:border-purple-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">This Month</p>
                <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                ৳{{ number_format($stats['this_month_revenue']) }}
            </p>
            <p class="text-[11px] text-purple-600 dark:text-purple-400 font-bold mt-1">
                {{ now()->format('F Y') }}
            </p>
        </div>

        <!-- Stat 3: Active Licenses -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-sky-400 dark:hover:border-sky-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Active Licenses</p>
                <div class="w-10 h-10 rounded-2xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $stats['active_licenses'] }}
            </p>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                Provisioned Seats
            </p>
        </div>

        <!-- Stat 4: Pending Approval Orders -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-amber-400 dark:hover:border-amber-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Pending Orders</p>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $stats['pending_orders'] }}
            </p>
            @if($stats['pending_orders'] > 0)
                <p class="text-[11px] text-amber-600 dark:text-amber-400 font-bold mt-1 flex items-center gap-1 animate-pulse">
                    <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Action Required
                </p>
            @else
                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold mt-1">
                    All clear
                </p>
            @endif
        </div>

        <!-- Stat 5: Total Customers -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-blue-400 dark:hover:border-blue-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Customers</p>
                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $stats['total_users'] }}
            </p>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                Registered Users
            </p>
        </div>

        <!-- Stat 6: Open Tickets -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-rose-400 dark:hover:border-rose-600 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Help Desk</p>
                <div class="w-10 h-10 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $stats['open_tickets'] }}
            </p>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                Open Tickets
            </p>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 3. INTERACTIVE CHARTS SECTION (APEXCHARTS)                        -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Revenue & Orders 7-Day Trend Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-[#0067b8] dark:text-sky-400"></i>
                        <span>Revenue & Orders Velocity (Last 7 Days)</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daily income volume in BDT and order transaction counts.</p>
                </div>
                <div class="flex items-center gap-3 text-xs font-bold">
                    <span class="flex items-center gap-1.5 text-[#0067b8] dark:text-sky-400">
                        <span class="w-3 h-3 rounded-full bg-[#0067b8]"></span> Revenue (৳)
                    </span>
                    <span class="flex items-center gap-1.5 text-emerald-500">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Orders
                    </span>
                </div>
            </div>

            <div class="mt-4" id="revenue-orders-chart" style="min-height: 300px;">
                <!-- ApexChart Render Target -->
            </div>
        </div>

        <!-- Right 1 Col: Payment Methods & Plan Distribution -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-purple-500"></i>
                            <span>Orders by Payment Method</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Distribution across gateways.</p>
                    </div>
                </div>

                <div class="mt-4" id="payment-method-chart" style="min-height: 250px;">
                    <!-- Donut Chart Render Target -->
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 grid grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Active Gateways</p>
                    <p class="text-sm font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['active_gateways'] }}</p>
                </div>
                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Active Coupons</p>
                    <p class="text-sm font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['active_coupons'] }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 4. PENDING ORDERS (IMMEDIATE ACTION REQUIRED) & PLAN BREAKDOWN    -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Pending Orders Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Pending License Orders</h3>
                        @if(count($pendingOrders) > 0)
                            <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-amber-500 text-white animate-pulse">
                                {{ count($pendingOrders) }} Pending
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Orders awaiting payment verification or admin approval.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1 self-start sm:self-auto">
                    <span>Manage All Orders</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="pb-3">Order Number</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Plan Name</th>
                            <th class="pb-3">Method</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($pendingOrders as $order)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-3.5 font-mono font-bold text-slate-900 dark:text-white">
                                    #{{ $order->order_number }}
                                    <div class="text-[10px] text-slate-400 font-normal">{{ $order->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="py-3.5">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $order->recipient_name }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $order->recipient_email }}</p>
                                </td>
                                <td class="py-3.5 font-semibold text-slate-900 dark:text-white">
                                    {{ $order->plan_name }}
                                </td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center gap-1 font-bold text-[11px] px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ strtoupper($order->paymentMethod->name ?? $order->payment_method_slug ?: 'Manual') }}
                                    </span>
                                </td>
                                <td class="py-3.5 font-extrabold text-slate-900 dark:text-white">
                                    ৳{{ number_format($order->payable_amount, 2) }}
                                </td>
                                <td class="py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="px-2.5 py-1 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs inline-flex items-center gap-1 transition-all shadow-xs">
                                            <span>Review & Approve</span>
                                            <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-circle-check text-2xl text-emerald-500 mb-1"></i>
                                    <p class="font-bold text-slate-700 dark:text-slate-300">No Pending Orders</p>
                                    <p class="text-[11px] text-slate-400">All customer license orders have been verified & approved.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right 1 Col: Active License Distribution by Plan -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-sky-500"></i>
                            <span>Active Licenses by Plan</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Provisioned seats breakdown.</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 font-bold text-xs border border-sky-200/60 dark:border-sky-800/60 shrink-0">
                        {{ $stats['active_licenses'] }} Active
                    </span>
                </div>

                <div class="mt-2 flex items-center justify-center" id="plan-distribution-chart" style="min-height: 220px;">
                    <!-- RadialBar Chart Target -->
                </div>
            </div>

            <!-- Detailed Plan Breakdown List with Progress Bars -->
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                @php
                    $planColors = ['#0067b8', '#00a4ef', '#10b981', '#8b5cf6', '#f59e0b', '#ec4899'];
                    $totalActiveSeats = (int) $stats['active_licenses'];
                @endphp
                @forelse($plans as $idx => $plan)
                    @php
                        $color = $planColors[$idx % count($planColors)];
                        $seatCount = $plan->subscriptions_count ?? 0;
                        $percent = $totalActiveSeats > 0 ? round(($seatCount / $totalActiveSeats) * 100) : 0;
                    @endphp
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-2xs" style="background-color: {{ $color }};"></span>
                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate">{{ $plan->name }}</span>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="font-extrabold text-slate-900 dark:text-white">{{ $seatCount }} <span class="text-[10px] font-normal text-slate-400">seats</span></span>
                                <span class="text-[10px] font-bold text-slate-400 w-8 text-right">{{ $percent }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700 ease-out" style="width: {{ $percent }}%; background-color: {{ $color }};"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-2">No plans available.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 5. RECENT SUPPORT TICKETS & RECENT CUSTOMER REGISTRATIONS         -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left: Recent Support Tickets -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-amber-500"></i>
                        <span>Customer Support Tickets</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Recent inquiries and support requests.</p>
                </div>
                <a href="{{ route('admin.tickets.index') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                    View All &rarr;
                </a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($recentTickets as $ticket)
                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="block p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/50 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 transition-all">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-[11px] font-bold text-[#0067b8] dark:text-sky-400">
                                #{{ $ticket->ticket_number }}
                            </span>
                            <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-full border {{ $ticket->status_badge }}">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                        </div>
                        <p class="text-xs font-extrabold text-slate-900 dark:text-white mt-1 line-clamp-1">
                            {{ $ticket->subject }}
                        </p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 mt-1">
                            <span>{{ $ticket->user->name ?? 'Customer' }} • {{ ucfirst($ticket->department) }}</span>
                            <span>{{ $ticket->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        <p class="font-bold text-slate-600 dark:text-slate-300">No Support Tickets</p>
                        <p class="text-[11px] text-slate-400">All customer queries are currently resolved.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Registered Customer Accounts -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-users text-blue-500"></i>
                        <span>Recent Customer Registrations</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Latest user accounts joined on platform.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                    View All &rarr;
                </a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($recentUsers as $u)
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($u->photo)
                                <img src="{{ asset($u->photo) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0" alt="{{ $u->name }}" />
                            @else
                                <div class="w-9 h-9 rounded-xl bg-slate-200 dark:bg-slate-700 text-[#0067b8] dark:text-sky-400 font-black text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ $u->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300' : 'bg-sky-50 text-[#0067b8] dark:bg-sky-950 dark:text-sky-300' }}">
                                {{ $u->role }}
                            </span>
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline px-2 py-1">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-400">
                        <p>No customers registered yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 6. CONTACT MESSAGES & SYSTEM CONFIG STATUS                        -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Contact Inquiries -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-emerald-500"></i>
                        <span>Recent Website Contact Messages</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Inquiries received from landing page contact form.</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                    View All Messages &rarr;
                </a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($recentMessages as $msg)
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs text-slate-900 dark:text-white">{{ $msg->name }}</span>
                                @if(!$msg->is_read)
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-500 text-white">
                                        New
                                    </span>
                                @endif
                                <span class="text-[10px] text-slate-400">• {{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-1">
                                {{ $msg->message }}
                            </p>
                        </div>
                        <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline shrink-0">
                            Read Message &rarr;
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-slate-400">
                        <p>No new contact messages.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right 1 Col: Platform Health & Service Status -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
            <div class="pb-4 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-server text-sky-500"></i>
                    <span>System & Platform Status</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Core services operational state.</p>
            </div>

            <div class="mt-4 space-y-3 text-xs">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                    <span class="font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-[#0067b8]"></i> Mail SMTP Server
                    </span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Online
                    </span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                    <span class="font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-database text-purple-500"></i> Database Storage
                    </span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Connected
                    </span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                    <span class="font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-amber-500"></i> Payment Gateways
                    </span>
                    <span class="font-bold text-slate-900 dark:text-white">
                        {{ $stats['active_gateways'] }} Active
                    </span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                    <span class="font-bold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-sky-500"></i> Laravel Optimization
                    </span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">
                        Cached & Optimized
                    </span>
                </div>

                <div class="pt-2">
                    <a href="{{ route('admin.smtp.edit') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center justify-center gap-1.5 transition-colors">
                        <i class="fa-solid fa-gear text-xs"></i>
                        <span>Manage SMTP Settings</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? '#1e293b' : '#f1f5f9';

        // 1. REVENUE & ORDERS AREA/LINE CHART
        const trendDates = @json($trendDates);
        const revenueTrend = @json($revenueTrend);
        const ordersTrend = @json($ordersTrend);

        const revenueOptions = {
            series: [
                {
                    name: 'Revenue (৳)',
                    type: 'area',
                    data: revenueTrend
                },
                {
                    name: 'Orders',
                    type: 'column',
                    data: ordersTrend
                }
            ],
            chart: {
                height: 310,
                type: 'line',
                toolbar: { show: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#0067b8', '#10b981'],
            stroke: {
                curve: 'smooth',
                width: [3, 0]
            },
            fill: {
                type: ['gradient', 'solid'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            labels: trendDates,
            xaxis: {
                labels: { style: { colors: textColor, fontSize: '11px', fontWeight: 600 } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: [
                {
                    title: { text: 'Revenue (৳)', style: { color: textColor, fontWeight: 700, fontSize: '11px' } },
                    labels: {
                        style: { colors: textColor, fontSize: '11px' },
                        formatter: function (val) { return '৳' + Number(val).toLocaleString(); }
                    }
                },
                {
                    opposite: true,
                    title: { text: 'Orders Count', style: { color: textColor, fontWeight: 700, fontSize: '11px' } },
                    labels: {
                        style: { colors: textColor, fontSize: '11px' },
                        formatter: function (val) { return Math.round(val); }
                    }
                }
            ],
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4
            },
            legend: { show: false },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function (val, { seriesIndex }) {
                        if (seriesIndex === 0) return '৳' + Number(val).toLocaleString('en-US', {minimumFractionDigits: 2});
                        return val + ' Orders';
                    }
                }
            }
        };

        const revenueChart = new ApexCharts(document.querySelector("#revenue-orders-chart"), revenueOptions);
        revenueChart.render();

        // 2. PAYMENT METHODS DONUT CHART
        const pmLabels = @json($pmLabels);
        const pmSeries = @json($pmSeries);

        const pmOptions = {
            series: pmSeries.length > 0 && pmSeries.some(v => v > 0) ? pmSeries : [1],
            labels: pmLabels.length > 0 && pmSeries.some(v => v > 0) ? pmLabels : ['No Orders Yet'],
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            colors: ['#0067b8', '#ec4899', '#f59e0b', '#10b981', '#8b5cf6'],
            legend: {
                position: 'bottom',
                fontSize: '11px',
                labels: { colors: textColor }
            },
            stroke: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Orders',
                                color: textColor,
                                fontSize: '11px',
                                fontWeight: 700,
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: { theme: isDark ? 'dark' : 'light' }
        };

        const pmChart = new ApexCharts(document.querySelector("#payment-method-chart"), pmOptions);
        pmChart.render();

        // 3. PLAN ACTIVE SUBSCRIPTION RADIALBAR CHART
        const planLabels = @json($planLabels);
        const planSeriesCounts = @json($planSeries);
        const totalActiveSeats = {{ (int) $stats['active_licenses'] }};

        let planPercentages = [];
        if (totalActiveSeats > 0) {
            planPercentages = planSeriesCounts.map(count => Math.round((count / totalActiveSeats) * 100));
        } else {
            planPercentages = planSeriesCounts.map(() => 0);
        }

        const planOptions = {
            series: planPercentages.length > 0 ? planPercentages : [0],
            chart: {
                height: 250,
                type: 'radialBar',
                fontFamily: 'Plus Jakarta Sans, sans-serif'
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 360,
                    hollow: {
                        margin: 6,
                        size: '30%',
                        background: 'transparent',
                    },
                    track: {
                        show: true,
                        background: isDark ? '#1e293b' : '#f1f5f9',
                        strokeWidth: '95%',
                        opacity: 1,
                        margin: 5
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: '11px',
                            fontWeight: 600,
                            color: textColor,
                            offsetY: -8
                        },
                        value: {
                            show: true,
                            fontSize: '15px',
                            fontWeight: 800,
                            color: isDark ? '#ffffff' : '#0f172a',
                            offsetY: 4,
                            formatter: function (val, opts) {
                                const index = (opts && typeof opts.seriesIndex !== 'undefined') ? opts.seriesIndex : 0;
                                const count = planSeriesCounts[index] !== undefined ? planSeriesCounts[index] : 0;
                                return count + ' Seats (' + val + '%)';
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total Active',
                            color: textColor,
                            fontSize: '11px',
                            fontWeight: 700,
                            formatter: function () {
                                return totalActiveSeats + ' Seats';
                            }
                        }
                    }
                }
            },
            colors: ['#0067b8', '#00a4ef', '#10b981', '#8b5cf6', '#f59e0b', '#ec4899'],
            labels: planLabels.length > 0 ? planLabels : ['No Plans'],
            legend: {
                show: false
            },
            stroke: {
                lineCap: 'round'
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light'
            }
        };

        const planChart = new ApexCharts(document.querySelector("#plan-distribution-chart"), planOptions);
        planChart.render();
    });
</script>
@endpush
