@extends('layouts.admin.admin')

@section('title', 'Record Manual / Office Payment - Admin Control Center')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.payments.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white">Payments</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Record Manual / Office Payment</span>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-black uppercase tracking-wider bg-emerald-600 text-white px-2.5 py-0.5 rounded-md flex items-center gap-1.5">
                    <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                    <span>Office Desk & Direct Payment</span>
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                Record Manual Payment
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Register offline cash payments, direct bank deposits, or in-person walk-in orders with immediate license provisioning.
            </p>
        </div>

        <a href="{{ route('admin.payments.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs flex items-center gap-2 transition-colors self-start sm:self-auto cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Payments</span>
        </a>
    </div>

    <!-- Main Entry Form -->
    <form action="{{ route('admin.payments.store-manual') }}" method="POST" class="space-y-6" id="manual-payment-form">
        @csrf

        <!-- ============================================================= -->
        <!-- 1. CUSTOMER SELECTION / REGISTRATION                          -->
        <!-- ============================================================= -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-user-circle text-[#0067b8]"></i>
                        <span>Customer Information</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Select an existing customer or register a new walk-in client.</p>
                </div>

                <!-- Customer Type Segmented Switcher -->
                <div class="flex items-center p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                    <label class="cursor-pointer">
                        <input type="radio" name="customer_type" value="existing" checked onchange="toggleCustomerType('existing')" class="sr-only peer">
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:text-[#0067b8] dark:peer-checked:text-sky-400 peer-checked:shadow-xs text-slate-500 block">
                            Existing User
                        </span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="customer_type" value="new" onchange="toggleCustomerType('new')" class="sr-only peer">
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400 peer-checked:shadow-xs text-slate-500 block">
                            + New Walk-in Client
                        </span>
                    </label>
                </div>
            </div>

            <!-- Existing Customer Search / Dropdown -->
            <div id="section-existing-customer" class="space-y-3">
                <label for="user_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                    Select Customer Account <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="user_id" id="user_id" onchange="handleUserSelection(this)" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        <option value="">-- Choose Customer (Search by Name or Email) --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                    data-name="{{ $user->name }}" 
                                    data-email="{{ $user->email }}" 
                                    data-phone="{{ $user->phone }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) {{ $user->phone ? '• ' . $user->phone : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <p class="text-xs text-red-600 dark:text-red-400 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Customer Form (Hidden by default) -->
            <div id="section-new-customer" class="hidden space-y-4 pt-2">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label for="new_user_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Customer Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="new_user_name" id="new_user_name" value="{{ old('new_user_name') }}" placeholder="e.g. Shakhawat Hossain" oninput="syncRecipientName(this.value)" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        @error('new_user_name')
                            <p class="text-xs text-red-600 dark:text-red-400 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="new_user_email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Customer Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="new_user_email" id="new_user_email" value="{{ old('new_user_email') }}" placeholder="customer@gmail.com" oninput="syncRecipientEmail(this.value)" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        @error('new_user_email')
                            <p class="text-xs text-red-600 dark:text-red-400 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="new_user_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Mobile Number
                        </label>
                        <input type="text" name="new_user_phone" id="new_user_phone" value="{{ old('new_user_phone') }}" placeholder="017XXXXXXXX" oninput="syncRecipientPhone(this.value)" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="new_user_password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Account Password (Optional - Leave blank to auto-generate & email to customer)
                    </label>
                    <input type="text" name="new_user_password" id="new_user_password" placeholder="Custom password (optional)" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 2. PLAN & PRICING SPECIFICATION                               -->
        <!-- ============================================================= -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-box-open text-[#0067b8]"></i>
                    <span>Plan & Pricing Details</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Select a Microsoft 365 package or specify a custom payment amount.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Pricing Plan Dropdown -->
                <div class="sm:col-span-2 space-y-1.5">
                    <label for="pricing_plan_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Select Pricing Plan <span class="text-red-500">*</span>
                    </label>
                    <select name="pricing_plan_id" id="pricing_plan_id" onchange="handlePlanSelection(this)" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        <option value="">-- Custom / Manual Entry --</option>
                        @foreach($pricingPlans as $plan)
                            <option value="{{ $plan->id }}" 
                                    data-name="{{ $plan->name }}" 
                                    data-price="{{ $plan->numeric_price }}"
                                    data-period="{{ $plan->billing_period }}"
                                    {{ old('pricing_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} — ৳{{ number_format($plan->numeric_price, 2) }} ({{ $plan->billing_period }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Plan Name -->
                <div class="sm:col-span-2 space-y-1.5">
                    <label for="plan_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Plan / Item Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plan_name" id="plan_name" value="{{ old('plan_name', 'Microsoft 365 Family') }}" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <!-- Base Plan Price -->
                <div class="space-y-1.5">
                    <label for="plan_price" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Regular Price (৳) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="plan_price" id="plan_price" value="{{ old('plan_price', '2490') }}" required oninput="calculatePayable()" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <!-- Discount Amount -->
                <div class="space-y-1.5">
                    <label for="discount_amount" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Discount / Waiver (৳)
                    </label>
                    <input type="number" step="0.01" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', '0') }}" oninput="calculatePayable()" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <!-- Final Payable Amount -->
                <div class="sm:col-span-2 space-y-1.5">
                    <label for="payable_amount" class="block text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">
                        Total Amount Received (৳) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none font-bold text-emerald-600 text-sm">৳</span>
                        <input type="number" step="0.01" name="payable_amount" id="payable_amount" value="{{ old('payable_amount', '2490') }}" required class="w-full pl-8 pr-4 py-2.5 bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-300 dark:border-emerald-700 rounded-xl text-sm font-mono font-black text-emerald-700 dark:text-emerald-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 3. PAYMENT TRANSACTION & OFFICE RECEIPT DETAILS               -->
        <!-- ============================================================= -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-[#0067b8]"></i>
                    <span>Payment Method & Office Voucher Reference</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Specify payment channel, receipt number, and received date.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Payment Method -->
                <div class="space-y-1.5">
                    <label for="payment_method_slug" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Payment Method <span class="text-red-500">*</span>
                    </label>
                    <select name="payment_method_slug" id="payment_method_slug" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        <option value="office_cash" selected>🏢 Cash (Office Walk-in Desk)</option>
                        <option value="bank_transfer">🏦 Direct Bank Deposit / Wire</option>
                        <option value="pos_card">💳 Office POS / Card Terminal</option>
                        <option value="bkash_manual">📱 bKash (Direct Send Money / QR)</option>
                        <option value="nagad_manual">📱 Nagad (Direct Send Money)</option>
                        <option value="rocket_manual">📱 Rocket / Upay (Manual)</option>
                        <option value="manual">📁 Other Manual / Offline</option>
                    </select>
                </div>

                <!-- Receipt / TXN Number -->
                <div class="space-y-1.5">
                    <label for="gateway_txn_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Receipt / Voucher / TXN No.
                    </label>
                    <input type="text" name="gateway_txn_id" id="gateway_txn_id" value="{{ old('gateway_txn_id') }}" placeholder="e.g. REC-2026-0082 or Bank Slip #" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <!-- Payment Received Date & Time -->
                <div class="space-y-1.5">
                    <label for="paid_at" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Received Date & Time
                    </label>
                    <input type="datetime-local" name="paid_at" id="paid_at" value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>
            </div>

            <!-- Recipient Account for Microsoft 365 License -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div class="space-y-1.5">
                    <label for="recipient_email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        License Email (Microsoft Account) <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="recipient_email" id="recipient_email" value="{{ old('recipient_email') }}" required placeholder="email@outlook.com or gmail.com" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <div class="space-y-1.5">
                    <label for="recipient_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        License Recipient Name
                    </label>
                    <input type="text" name="recipient_name" id="recipient_name" value="{{ old('recipient_name') }}" placeholder="Full Name" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <div class="space-y-1.5">
                    <label for="recipient_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        Recipient Contact Phone
                    </label>
                    <input type="text" name="recipient_phone" id="recipient_phone" value="{{ old('recipient_phone') }}" placeholder="017XXXXXXXX" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 4. AUTOMATIC SUBSCRIPTION ACTIVATION & ADMIN NOTES            -->
        <!-- ============================================================= -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-[#0067b8]"></i>
                    <span>License Provisioning & Admin Notes</span>
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Control automatic subscription creation and internal records.</p>
            </div>

            <div class="space-y-4">
                <!-- Checkbox to Activate Subscription Immediately -->
                <div class="p-4 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800 flex items-start gap-3.5">
                    <input type="checkbox" name="activate_subscription" id="activate_subscription" value="1" checked class="mt-0.5 w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                    <div>
                        <label for="activate_subscription" class="text-xs font-bold text-slate-900 dark:text-white cursor-pointer">
                            Immediately Activate / Renew Customer Subscription
                        </label>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                            Automatically provisions the license key, updates customer dashboard validity, and sends email confirmation.
                        </p>
                    </div>
                </div>

                <!-- Validity Duration -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="duration_months" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Subscription Validity Duration
                        </label>
                        <select name="duration_months" id="duration_months" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                            <option value="12" selected>1 Year (12 Months Validity)</option>
                            <option value="1">1 Month</option>
                            <option value="3">3 Months</option>
                            <option value="6">6 Months</option>
                            <option value="24">2 Years (24 Months)</option>
                            <option value="36">3 Years (36 Months)</option>
                        </select>
                    </div>

                    <!-- Internal Remarks -->
                    <div class="space-y-1.5">
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                            Internal Office Notes / Remarks
                        </label>
                        <input type="text" name="notes" id="notes" value="{{ old('notes', 'Received cash in officedesk.') }}" placeholder="e.g. Received by Admin Shakhawat" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 5. ACTION BUTTONS                                             -->
        <!-- ============================================================= -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.payments.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-7 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs flex items-center gap-2 transition-all shadow-md shadow-emerald-600/20 active:scale-95 cursor-pointer">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Confirm & Record Manual Payment</span>
            </button>
        </div>

    </form>
</div>

<!-- ============================================================= -->
<!-- FORM DYNAMIC INTERACTION SCRIPT                               -->
<!-- ============================================================= -->
<script>
    function toggleCustomerType(type) {
        const existingSection = document.getElementById('section-existing-customer');
        const newSection = document.getElementById('section-new-customer');
        const userInput = document.getElementById('user_id');

        if (type === 'new') {
            existingSection.classList.add('hidden');
            newSection.classList.remove('hidden');
            userInput.removeAttribute('required');
        } else {
            existingSection.classList.remove('hidden');
            newSection.classList.add('hidden');
            userInput.setAttribute('required', 'required');
        }
    }

    function handleUserSelection(select) {
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const name = selected.getAttribute('data-name');
            const email = selected.getAttribute('data-email');
            const phone = selected.getAttribute('data-phone');

            document.getElementById('recipient_name').value = name || '';
            document.getElementById('recipient_email').value = email || '';
            document.getElementById('recipient_phone').value = phone || '';
        }
    }

    function syncRecipientName(val) {
        document.getElementById('recipient_name').value = val;
    }

    function syncRecipientEmail(val) {
        document.getElementById('recipient_email').value = val;
    }

    function syncRecipientPhone(val) {
        document.getElementById('recipient_phone').value = val;
    }

    function handlePlanSelection(select) {
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            const name = selected.getAttribute('data-name');
            const price = parseFloat(selected.getAttribute('data-price')) || 0;
            const period = selected.getAttribute('data-period') || '';

            document.getElementById('plan_name').value = name;
            document.getElementById('plan_price').value = price;
            
            // Adjust duration dropdown if period is monthly
            const durationSelect = document.getElementById('duration_months');
            if (period.toLowerCase().includes('month')) {
                durationSelect.value = "1";
            } else {
                durationSelect.value = "12";
            }

            calculatePayable();
        }
    }

    function calculatePayable() {
        const price = parseFloat(document.getElementById('plan_price').value) || 0;
        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const payable = Math.max(0, price - discount);
        document.getElementById('payable_amount').value = payable.toFixed(2);
    }
</script>
@endsection
