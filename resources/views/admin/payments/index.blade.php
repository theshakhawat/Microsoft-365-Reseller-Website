@extends('layouts.admin.admin')

@section('title', 'Payments & Transactions Log | Microsoft Office Club Admin')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Payments</span>
@endsection

@section('content')

    <div class="space-y-6">
        
        <!-- Header & Metrics -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Payments & Transactions
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Real-time transaction logs from bKash, Nagad, MoneyBag, and in-office manual payments.
                </p>
            </div>

            <!-- Action: Record Manual / Office Payment -->
            <a href="{{ route('admin.payments.create') }}" class="px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs flex items-center gap-2 transition-all shadow-md shadow-emerald-600/20 active:scale-95 self-start sm:self-auto cursor-pointer">
                <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                <span>+ Record Manual / Office Payment</span>
            </a>
        </div>

        <!-- Metric Badges -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-gradient-to-tr from-[#0067b8] to-sky-500 text-white shadow-sm">
                <p class="text-[11px] font-bold text-sky-100 uppercase tracking-wider">Total Verified Revenue</p>
                <p class="text-2xl font-black mt-1">৳{{ number_format($counts['total_revenue'], 2) }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800">
                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Completed Payments</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['paid_count'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800">
                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Pending Orders</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['pending_count'] }}</p>
            </div>

            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800">
                <p class="text-[11px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Failed / Cancelled</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['failed_count'] }}</p>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="flex-1 w-full flex flex-col sm:flex-row items-center gap-2">
                <div class="relative flex-1 w-full">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order #, TXN ID, customer name, email..." class="w-full pl-9 pr-3.5 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <select name="method" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300">
                        <option value="">All Methods / Gateways</option>
                        <option value="office_cash" {{ request('method') === 'office_cash' ? 'selected' : '' }}>🏢 Office Cash</option>
                        <option value="bank_transfer" {{ request('method') === 'bank_transfer' ? 'selected' : '' }}>🏦 Bank Deposit</option>
                        <option value="pos_card" {{ request('method') === 'pos_card' ? 'selected' : '' }}>💳 Office POS / Card</option>
                        @foreach($paymentMethods as $pm)
                            <option value="{{ $pm->slug }}" {{ request('method') === $pm->slug ? 'selected' : '' }}>
                                {{ $pm->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition-all shrink-0">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200/90 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">Order # & Timestamp</th>
                            <th class="py-3.5 px-4">Customer Account</th>
                            <th class="py-3.5 px-4">Method</th>
                            <th class="py-3.5 px-4">Gateway TXN Reference</th>
                            <th class="py-3.5 px-4">Amount</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($payments as $pay)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-slate-900 dark:text-white block">{{ $pay->order_number }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $pay->created_at->format('M d, Y • h:i A') }}</span>
                                </td>

                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $pay->user->name ?? ($pay->recipient_name ?? 'Customer') }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ $pay->recipient_email }}</p>
                                </td>

                                <td class="py-3.5 px-4">
                                    @if(in_array($pay->payment_method_slug, ['office_cash', 'cash', 'manual']))
                                        <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-2.5 py-1 rounded-lg">
                                            <i class="fa-solid fa-money-bill-wave text-[10px]"></i>
                                            <span>Office Cash</span>
                                        </span>
                                    @elseif($pay->payment_method_slug === 'bank_transfer')
                                        <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-2.5 py-1 rounded-lg">
                                            <i class="fa-solid fa-building-columns text-[10px]"></i>
                                            <span>Bank Deposit</span>
                                        </span>
                                    @elseif($pay->payment_method_slug === 'pos_card')
                                        <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-400 border border-purple-200 dark:border-purple-800 px-2.5 py-1 rounded-lg">
                                            <i class="fa-solid fa-credit-card text-[10px]"></i>
                                            <span>Office POS</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-lg">
                                            @if($pay->paymentMethod && $pay->paymentMethod->logo_url)
                                                <img src="{{ $pay->paymentMethod->logo_url }}" alt="{{ $pay->paymentMethod->name }}" class="w-4 h-4 object-contain shrink-0">
                                            @else
                                                <i class="fa-solid fa-wallet text-[10px] text-slate-400"></i>
                                            @endif
                                            <span>{{ strtoupper($pay->paymentMethod->name ?? $pay->payment_method_slug ?: 'Manual') }}</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 font-mono">
                                    @if($pay->gateway_txn_id || $pay->gateway_txn_number)
                                        <p class="font-bold text-slate-800 dark:text-slate-200">{{ $pay->gateway_txn_number ?: $pay->gateway_txn_id }}</p>
                                        <span class="text-[10px] text-slate-400">Ref: {{ $pay->gateway_txn_id }}</span>
                                    @else
                                        <span class="text-slate-400 font-bold text-xs">N/A</span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 font-black text-slate-900 dark:text-white text-sm">
                                    ৳{{ number_format($pay->payable_amount, 2) }}
                                </td>

                                <td class="py-3.5 px-4">
                                    @if($pay->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Paid</span>
                                        </span>
                                    @elseif($pay->payment_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400">
                                            <span>Pending</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400">
                                            <span>{{ ucfirst($pay->payment_status) }}</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('admin.orders.show', $pay->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors inline-block" title="View Order">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    No payment transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection
