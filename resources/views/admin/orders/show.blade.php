@extends('layouts.admin.admin')

@section('title', 'Order Details #' . $order->order_number . ' | Microsoft Office Club Admin')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.orders.index') }}" class="hover:text-[#0067b8] transition-colors">Orders</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">{{ $order->order_number }}</span>
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

    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Order #{{ $order->order_number }}
                    </h1>
                    @if($order->payment_status === 'paid')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                            Paid
                        </span>
                    @elseif($order->payment_status === 'pending')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                            Pending Approval
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-400">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-1">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                @php
                    $orderHasActiveSub = \App\Models\Subscription::where('order_id', $order->id)->where('status', 'active')->exists();
                @endphp

                @if(!$orderHasActiveSub && in_array($order->payment_status, ['pending', 'paid']))
                    <button type="button" 
                            onclick="openActionModal({
                                actionUrl: '{{ route('admin.orders.approve', $order->id) }}',
                                title: 'Approve Order #{{ $order->order_number }}?',
                                message: 'This will approve the order, confirm payment, and immediately activate customer {{ $order->recipient_name }}\'s 1-Year Microsoft 365 subscription.',
                                btnText: 'Yes, Approve & Activate License',
                                type: 'emerald',
                                icon: 'fa-solid fa-shield-halved'
                            })"
                            class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 shadow-md shadow-emerald-600/20 transition-all cursor-pointer active:scale-95">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>Approve & Activate License</span>
                    </button>
                @endif

                @if($order->payment_status !== 'cancelled')
                    <button type="button" 
                            onclick="openActionModal({
                                actionUrl: '{{ route('admin.orders.cancel', $order->id) }}',
                                title: 'Reject & Cancel Order #{{ $order->order_number }}?',
                                message: 'Are you sure you want to cancel this order? The customer subscription will not be provisioned.',
                                btnText: 'Yes, Cancel Order',
                                type: 'rose',
                                icon: 'fa-solid fa-ban'
                            })"
                            class="px-4 py-2.5 rounded-xl border border-rose-200 dark:border-rose-900 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/50 font-bold text-xs transition-all cursor-pointer active:scale-95">
                        <span>Reject / Cancel</span>
                    </button>
                @endif

                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                    ← Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left 2 Columns: Order Details & Payment Metadata -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Plan & Financial Breakdown Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-4 border-b border-slate-100 dark:border-slate-800">
                        Purchased Plan & Pricing
                    </h3>

                    <div class="mt-5 space-y-4 text-xs">
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50">
                            <div>
                                <h4 class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $order->plan_name }}</h4>
                                <p class="text-slate-400 text-[11px] mt-0.5">Original Plan ID: #{{ $order->pricing_plan_id }}</p>
                            </div>
                            <span class="font-bold text-slate-900 dark:text-white text-sm">৳{{ number_format($order->plan_price, 2) }}</span>
                        </div>

                        <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex justify-between text-slate-500 dark:text-slate-400">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-800 dark:text-slate-200">৳{{ number_format($order->plan_price, 2) }}</span>
                            </div>

                            @if($order->coupon_code)
                                <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-bold">
                                    <span>Discount (Coupon: {{ $order->coupon_code }})</span>
                                    <span>- ৳{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-sm font-black text-slate-900 dark:text-white pt-2 border-t border-slate-100 dark:border-slate-800">
                                <span>Final Payable Amount</span>
                                <span class="text-lg text-[#0067b8] dark:text-sky-400">৳{{ number_format($order->payable_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Gateway Logs & Proof -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-4 border-b border-slate-100 dark:border-slate-800">
                        Payment Gateway Details
                    </h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Payment Method</p>
                            <p class="font-bold text-slate-900 dark:text-white mt-1">{{ strtoupper($order->payment_method_slug ?: 'Manual') }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Gateway Transaction ID</p>
                            <p class="font-mono font-bold text-slate-900 dark:text-white mt-1">{{ $order->gateway_txn_id ?: 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">MFS / Third Party TXN Number</p>
                            <p class="font-mono font-bold text-slate-900 dark:text-white mt-1">{{ $order->gateway_txn_number ?: 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Payment Timestamp</p>
                            <p class="font-bold text-slate-900 dark:text-white mt-1">{{ $order->paid_at ? $order->paid_at->format('M d, Y • h:i A') : 'Pending Payment' }}</p>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Customer Order Notes</p>
                            <p class="text-slate-700 dark:text-slate-300 text-xs mt-1 italic bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl border border-slate-200/60 dark:border-slate-700">
                                "{{ $order->notes }}"
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right 1 Column: Customer & Subscription Info -->
            <div class="space-y-6">
                
                <!-- Recipient & Customer Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-4 border-b border-slate-100 dark:border-slate-800">
                        License Recipient
                    </h3>

                    <div class="mt-4 space-y-3.5 text-xs">
                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Name</p>
                            <p class="font-bold text-slate-900 dark:text-white mt-0.5">{{ $order->recipient_name }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">Microsoft Account Email</p>
                            <p class="font-bold text-[#0067b8] dark:text-sky-400 mt-0.5 break-all">{{ $order->recipient_email }}</p>
                        </div>

                        <div>
                            <p class="text-slate-400 font-bold uppercase text-[10px]">WhatsApp / Phone</p>
                            <p class="font-bold text-slate-900 dark:text-white mt-0.5">{{ $order->recipient_phone ?: 'Not provided' }}</p>
                        </div>

                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                            <p class="text-slate-400 font-bold uppercase text-[10px]">User Account</p>
                            <p class="font-semibold text-slate-700 dark:text-slate-300 mt-0.5">{{ $order->user->name }} ({{ $order->user->email }})</p>
                        </div>
                    </div>
                </div>

                <!-- Linked Subscription Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white pb-4 border-b border-slate-100 dark:border-slate-800">
                        Associated Subscription
                    </h3>

                    @if($existingSubscription)
                        <div class="mt-4 space-y-3 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 uppercase text-[10px] font-bold">Status</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $existingSubscription->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800' }}">
                                    {{ strtoupper($existingSubscription->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase text-[10px] font-bold block">License Key</span>
                                <span class="font-mono font-bold text-slate-900 dark:text-white text-[11px]">{{ $existingSubscription->subscription_key }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 uppercase text-[10px] font-bold block">Validity Period</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $existingSubscription->starts_at?->format('M d, Y') }} - {{ $existingSubscription->expires_at?->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('admin.subscriptions.edit', $existingSubscription->id) }}" class="w-full py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold rounded-xl text-center block text-xs transition-colors">
                                    Manage Subscription
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 text-center py-4 text-xs text-slate-400">
                            <i class="fa-solid fa-shield-halved text-2xl mb-2 text-slate-300 dark:text-slate-600"></i>
                            <p>No active subscription provisioned yet.</p>
                            @if($order->payment_status === 'pending')
                                <p class="text-[11px] text-amber-500 font-semibold mt-1">Approve this order to automatically activate the license.</p>
                            @endif
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

@endsection
