@extends('layouts.user.user')

@section('title', 'My Orders & Invoices | Microsoft Office Club')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Orders</span>
@endsection

@section('content')

    <!-- Flash Message -->
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

    @if(session('error'))
    <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-base text-rose-600 dark:text-rose-400"></i>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 dark:text-rose-400">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    @endif

    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    My License Orders
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Track your Microsoft 365 purchase orders, payment verification, and download official tax receipts.
                </p>
            </div>
            <a href="{{ route('user.plans') }}" class="px-4 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs flex items-center gap-2 shadow-sm shadow-[#0067b8]/20 transition-all self-start sm:self-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Order New Plan</span>
            </a>
        </div>

        <!-- Orders Table Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200/90 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-5">Order ID & Date</th>
                            <th class="py-3.5 px-4">Plan & Recipient</th>
                            <th class="py-3.5 px-4">Payment Method</th>
                            <th class="py-3.5 px-4">Total Amount</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-5 text-right">Invoice & Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-5">
                                    <span class="font-mono font-bold text-slate-900 dark:text-white block">{{ $order->order_number }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                                </td>

                                <td class="py-4 px-4">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $order->plan_name }}</p>
                                    <p class="text-[11px] text-[#0067b8] dark:text-sky-400 truncate">{{ $order->recipient_email }}</p>
                                    @if($order->coupon_code)
                                        <span class="inline-block text-[9px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 px-1.5 py-0.5 rounded mt-0.5">
                                            Coupon {{ $order->coupon_code }} (-৳{{ number_format($order->discount_amount, 2) }})
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-lg">
                                        @if($order->paymentMethod && $order->paymentMethod->logo_url)
                                            <img src="{{ $order->paymentMethod->logo_url }}" alt="{{ $order->paymentMethod->name }}" class="w-4 h-4 object-contain shrink-0">
                                        @else
                                            <i class="fa-solid fa-credit-card text-[10px] text-slate-400"></i>
                                        @endif
                                        <span>{{ strtoupper($order->paymentMethod->name ?? $order->payment_method_slug ?: 'Manual') }}</span>
                                    </span>
                                </td>

                                <td class="py-4 px-4 font-black text-slate-900 dark:text-white text-sm">
                                    ৳{{ number_format($order->payable_amount, 2) }}
                                </td>

                                <td class="py-4 px-4">
                                    @if($order->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Paid</span>
                                        </span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Pending Approval</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                            <span>{{ ucfirst($order->payment_status) }}</span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($order->payment_status === 'pending')
                                            <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this pending order?');" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1.5 rounded-xl border border-rose-200 dark:border-rose-900/50 hover:bg-rose-50 dark:hover:bg-rose-950/60 text-rose-600 dark:text-rose-400 font-bold text-xs inline-flex items-center gap-1 transition-all cursor-pointer" title="Cancel this order">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                    <span>Cancel</span>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('user.invoice', $order->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-[#0067b8] dark:text-sky-400 font-bold text-xs inline-flex items-center gap-1.5 transition-all">
                                            <i class="fa-solid fa-file-invoice text-xs"></i>
                                            <span>Invoice</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center text-slate-400">
                                    <i class="fa-solid fa-receipt text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                                    <p class="font-bold text-slate-600 dark:text-slate-300 text-sm">No Orders Placed Yet</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Explore our Microsoft 365 plans to get genuine licenses with 1TB cloud.</p>
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
