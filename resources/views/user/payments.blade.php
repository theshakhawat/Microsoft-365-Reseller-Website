@extends('layouts.user.user')

@section('title', 'Payment History & Receipts | Microsoft Office Club')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Payments</span>
@endsection

@section('content')

    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Payment History & Transactions
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Review your complete payment records, payment gateway IDs, and download official invoices.
                </p>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200/90 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-5">Order # & Timestamp</th>
                            <th class="py-3.5 px-4">Purchased License</th>
                            <th class="py-3.5 px-4">Gateway Method</th>
                            <th class="py-3.5 px-4">Transaction Reference</th>
                            <th class="py-3.5 px-4">Paid Amount</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-5 text-right">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($payments as $pay)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-5">
                                    <span class="font-mono font-bold text-slate-900 dark:text-white block">{{ $pay->order_number }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $pay->created_at->format('M d, Y • h:i A') }}</span>
                                </td>

                                <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                                    {{ $pay->plan_name }}
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-lg">
                                        @if($pay->paymentMethod && $pay->paymentMethod->logo_url)
                                            <img src="{{ $pay->paymentMethod->logo_url }}" alt="{{ $pay->paymentMethod->name }}" class="w-4 h-4 object-contain shrink-0">
                                        @else
                                            <i class="fa-solid fa-credit-card text-[10px] text-slate-400"></i>
                                        @endif
                                        <span>{{ strtoupper($pay->paymentMethod->name ?? $pay->payment_method_slug ?: 'Manual') }}</span>
                                    </span>
                                </td>

                                <td class="py-4 px-4 font-mono text-slate-600 dark:text-slate-300">
                                    @if($pay->gateway_txn_number || $pay->gateway_txn_id)
                                        <p class="font-bold text-slate-800 dark:text-slate-200">{{ $pay->gateway_txn_number ?: $pay->gateway_txn_id }}</p>
                                    @else
                                        <span class="text-slate-400 font-bold text-xs">N/A</span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 font-black text-slate-900 dark:text-white text-sm">
                                    ৳{{ number_format($pay->payable_amount, 2) }}
                                </td>

                                <td class="py-4 px-4">
                                    @if($pay->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Paid</span>
                                        </span>
                                    @elseif($pay->payment_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400">
                                            <span>Pending</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400">
                                            <span>{{ ucfirst($pay->payment_status) }}</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-5 text-right">
                                    <a href="{{ route('user.invoice', $pay->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-[#0067b8] dark:text-sky-400 font-bold text-xs inline-flex items-center gap-1.5 transition-all">
                                        <i class="fa-solid fa-file-pdf text-xs"></i>
                                        <span>Receipt</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-14 text-center text-slate-400">
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
