@extends('layouts.admin.admin')

@section('title', 'Orders & Customer Purchases | Microsoft Office Club Admin')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Orders</span>
@endsection

@section('content')

    <!-- Flash Success/Error Message -->
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    @endif

    <!-- Page Header & Metrics Bar -->
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Order Management
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Verify incoming customer orders, review payment proof, and approve license activation.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.payments.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-sm shadow-emerald-600/20 transition-all cursor-pointer">
                    <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                    <span>+ Record Office Payment</span>
                </a>
                <a href="{{ route('admin.subscriptions.create') }}" class="px-4 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs flex items-center gap-2 shadow-sm shadow-[#0067b8]/20 transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Manual Subscription</span>
                </a>
            </div>
        </div>

        <!-- Metric Status Badges -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.orders.index') }}" class="p-4 rounded-2xl border transition-all {{ !request('status') ? 'bg-[#0067b8]/10 border-[#0067b8] dark:bg-[#0067b8]/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">All Orders</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['all'] }}</p>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'pending' ? 'bg-amber-50 border-amber-400 dark:bg-amber-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Pending Approval</span>
                </p>
                <p class="text-xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $counts['pending'] }}</p>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'paid' ? 'bg-emerald-50 border-emerald-400 dark:bg-emerald-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Paid</p>
                <p class="text-xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $counts['paid'] }}</p>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'cancelled' ? 'bg-rose-50 border-rose-400 dark:bg-rose-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Cancelled</p>
                <p class="text-xl font-black text-rose-700 dark:text-rose-300 mt-1">{{ $counts['cancelled'] }}</p>
            </a>
        </div>

        <!-- Filter and Search Bar -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex-1 w-full flex items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order #, customer email, name, or plan..." class="w-full pl-9 pr-3.5 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition-all shrink-0">
                    Search
                </button>
            </form>
        </div>

        <!-- Orders Table Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200/90 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">Order ID & Date</th>
                            <th class="py-3.5 px-4">Customer & Recipient</th>
                            <th class="py-3.5 px-4">Plan</th>
                            <th class="py-3.5 px-4">Gateway</th>
                            <th class="py-3.5 px-4">Amount</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-slate-900 dark:text-white block">{{ $order->order_number }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                                </td>

                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $order->recipient_name }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ $order->recipient_email }}</p>
                                    @if($order->recipient_phone)
                                        <p class="text-[10px] text-emerald-600 dark:text-emerald-400">{{ $order->recipient_phone }}</p>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-slate-900 dark:text-white block">{{ $order->plan_name }}</span>
                                    @if($order->coupon_code)
                                        <span class="inline-block text-[9px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 px-1.5 py-0.5 rounded mt-0.5">
                                            Coupon: {{ $order->coupon_code }} (-৳{{ number_format($order->discount_amount, 2) }})
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2 py-1 rounded-lg">
                                        @if($order->paymentMethod && $order->paymentMethod->logo_url)
                                            <img src="{{ $order->paymentMethod->logo_url }}" alt="{{ $order->paymentMethod->name }}" class="w-4 h-4 object-contain shrink-0">
                                        @else
                                            <i class="fa-solid fa-credit-card text-[10px] text-slate-400"></i>
                                        @endif
                                        <span>{{ $order->paymentMethod->name ?? $order->payment_method_slug ?: 'Manual' }}</span>
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 font-black text-slate-900 dark:text-white text-sm">
                                    ৳{{ number_format($order->payable_amount, 2) }}
                                </td>

                                <td class="py-3.5 px-4">
                                    @if($order->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Paid</span>
                                        </span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Pending Approval</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                            <span>{{ ucfirst($order->payment_status) }}</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="View Details">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </a>

                                        @php
                                            $orderHasActiveSub = \App\Models\Subscription::where('order_id', $order->id)->where('status', 'active')->exists();
                                        @endphp

                                        @if(!$orderHasActiveSub && in_array($order->payment_status, ['pending', 'paid']))
                                            <button type="button" 
                                                    onclick="openActionModal({
                                                        actionUrl: '{{ route('admin.orders.approve', $order->id) }}',
                                                        title: 'Approve Order #{{ $order->order_number }}?',
                                                        message: 'This will approve the order, confirm payment, and instantly create and activate an official 1-Year Microsoft 365 subscription for customer {{ $order->recipient_name }}.',
                                                        btnText: 'Yes, Approve & Activate',
                                                        type: 'emerald',
                                                        icon: 'fa-solid fa-shield-halved'
                                                    })"
                                                    class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] flex items-center gap-1 transition-all cursor-pointer shadow-xs active:scale-95" 
                                                    title="Approve & Activate Subscription">
                                                <i class="fa-solid fa-check text-[10px]"></i>
                                                <span>Approve</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    No customer orders found matching the filter criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
