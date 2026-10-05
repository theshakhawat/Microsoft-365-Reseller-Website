<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - Microsoft Office Club Bangladesh</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased p-4 sm:p-8 min-h-screen flex flex-col items-center">

    <!-- Action Bar (Print / Download) -->
    <div class="max-w-3xl w-full mb-4 flex items-center justify-between no-print">
        <a href="{{ route('user.orders') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Orders</span>
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs flex items-center gap-2 shadow-md transition-all cursor-pointer">
            <i class="fa-solid fa-print text-xs"></i>
            <span>Print / Save as PDF</span>
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="max-w-3xl w-full bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 print-shadow-none">
        
        <!-- Top Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-8 border-b border-slate-200">
            <div>
                <img src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" class="h-10 w-auto object-contain" alt="Microsoft Office Club">
                <p class="text-xs text-slate-500 mt-2 font-medium">Authorized Microsoft Cloud Solution Provider (CSP) Reseller</p>
                <p class="text-xs text-slate-500">Dhaka, Bangladesh • support@microsoftoffice.club</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                    {{ $order->payment_status === 'paid' ? 'PAID & VERIFIED' : 'PENDING APPROVAL' }}
                </span>
                <p class="text-2xl font-black text-slate-900 mt-2">INVOICE</p>
                <p class="text-xs font-mono font-bold text-slate-500">#{{ $order->order_number }}</p>
            </div>
        </div>

        <!-- Billed To & Invoice Metadata -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-8 border-b border-slate-200 text-xs">
            <div>
                <p class="font-bold text-slate-400 uppercase text-[10px] tracking-wider mb-1">Billed To / Licensee:</p>
                <p class="text-sm font-extrabold text-slate-900">{{ $order->recipient_name ?: $order->user->name }}</p>
                <p class="text-slate-600 font-medium mt-0.5">{{ $order->recipient_email ?: $order->user->email }}</p>
                @if($order->recipient_phone)
                    <p class="text-slate-600 mt-0.5">{{ $order->recipient_phone }}</p>
                @endif
            </div>

            <div class="space-y-1 sm:text-right">
                <p><span class="text-slate-400 font-bold">Issue Date:</span> <span class="font-bold text-slate-800">{{ $order->created_at->format('M d, Y') }}</span></p>
                @if($order->paid_at)
                    <p><span class="text-slate-400 font-bold">Payment Date:</span> <span class="font-bold text-emerald-600">{{ $order->paid_at->format('M d, Y • h:i A') }}</span></p>
                @endif
                <p><span class="text-slate-400 font-bold">Payment Gateway:</span> <span class="font-bold text-slate-800 uppercase">{{ $order->payment_method_slug ?: 'Manual' }}</span></p>
                @if($order->gateway_txn_number || $order->gateway_txn_id)
                    <p><span class="text-slate-400 font-bold">TXN ID:</span> <span class="font-mono font-bold text-slate-800">{{ $order->gateway_txn_number ?: $order->gateway_txn_id }}</span></p>
                @endif
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b-2 border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                        <th class="pb-3">Description / Product License</th>
                        <th class="pb-3 text-center">Qty</th>
                        <th class="pb-3 text-right">Price</th>
                        <th class="pb-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="py-4">
                            <p class="font-extrabold text-slate-900 text-sm">{{ $order->plan_name }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Includes genuine Microsoft apps, 1TB OneDrive cloud storage & 24/7 priority support.</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Licensed to: {{ $order->recipient_email }}</p>
                        </td>
                        <td class="py-4 text-center font-bold">1</td>
                        <td class="py-4 text-right font-medium">৳{{ number_format($order->plan_price, 2) }}</td>
                        <td class="py-4 text-right font-bold text-slate-900">৳{{ number_format($order->plan_price, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Financial Summary Breakdown -->
            <div class="mt-6 pt-4 border-t border-slate-200 space-y-2 text-xs flex flex-col items-end">
                <div class="flex justify-between w-64 text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-bold text-slate-900">৳{{ number_format($order->plan_price, 2) }}</span>
                </div>

                @if($order->coupon_code)
                    <div class="flex justify-between w-64 text-emerald-600 font-bold">
                        <span>Discount ({{ $order->coupon_code }})</span>
                        <span>- ৳{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                @endif

                <div class="flex justify-between w-64 text-slate-600">
                    <span>Setup & Cloud Provisioning</span>
                    <span class="font-bold text-emerald-600 uppercase text-[10px]">Free</span>
                </div>

                <div class="flex justify-between w-64 text-base font-black text-slate-900 pt-3 border-t-2 border-slate-900">
                    <span>Total Paid</span>
                    <span class="text-[#0067b8]">৳{{ number_format($order->payable_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer / Notice -->
        <div class="pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-400">
            <div>
                <p class="font-bold text-slate-700">Thank you for choosing {{ site_setting('site_name', 'Microsoft Office Club') }}!</p>
                <p class="text-[11px] mt-0.5">For activation help or questions, WhatsApp us at {{ site_setting('whatsapp_number', '+880 1342-325558') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <span class="text-[10px] font-bold uppercase text-slate-500">Official Partner Provisioned</span>
            </div>
        </div>

    </div>

</body>
</html>
