@extends('layouts.user.user')

@section('title', 'Checkout & Order Summary - ' . $plan->name . ' | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('user.plans') }}" class="hover:text-[#0067b8] transition-colors">Pricing Plans</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Checkout</span>
@endsection

@section('content')

    <!-- Flash Success / Error Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
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
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-base text-red-600 dark:text-red-400"></i>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 dark:text-red-400">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs sm:text-sm space-y-1 shadow-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i class="fa-solid fa-circle-exclamation text-base text-red-600 dark:text-red-400"></i>
                <span>Notice:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <!-- ========================================== -->
        <!-- LEFT COLUMN (7 Cols): Selected Plan & Payment Methods -->
        <!-- ========================================== -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- 1. Selected Plan Details Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Selected Subscription Plan</h2>
                            <p class="text-xs text-slate-400">Review selected license specifications</p>
                        </div>
                    </div>
                    <a href="{{ route('user.plans') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrows-rotate text-[10px]"></i>
                        <span>Change Plan</span>
                    </a>
                </div>

                <div class="mt-5 space-y-4">
                    @php
                        $userSub = Auth::user()->activeSubscription();
                        $isUpgrade = $userSub && !str_contains(strtolower($userSub->plan_name), 'personal') && str_contains(strtolower($plan->name), 'personal');
                    @endphp

                    @if($isUpgrade)
                        <div class="p-4 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-sky-500/10 border border-emerald-300 dark:border-emerald-800 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                <i class="fa-solid fa-arrow-trend-up text-sm"></i>
                            </div>
                            <div class="text-xs">
                                <p class="font-extrabold text-emerald-900 dark:text-emerald-200">Plan Upgrade: {{ $userSub->plan_name }} &rarr; {{ $plan->name }}</p>
                                <p class="text-emerald-700 dark:text-emerald-300 mt-0.5 leading-relaxed">
                                    Your existing Basic plan currently has <strong>{{ $userSub->remaining_days }} days remaining</strong>. When this Personal upgrade is activated, those <strong>+{{ $userSub->remaining_days }} extra days</strong> will be automatically added to your new 1-Year subscription period!
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-800">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white flex items-center justify-center font-black text-lg shadow-sm">
                                365
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">{{ $plan->name }}</h3>
                                    @if($plan->badge)
                                        <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-[#0067b8] text-white">
                                            {{ $plan->badge }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Billing: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $plan->billing_period }}</span>
                                    @if($plan->price_usd)
                                        • Approx. {{ $plan->price_usd }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ $plan->price_bdt }}
                            </span>
                        </div>
                    </div>

                    <!-- Included Apps List -->
                    @if(!empty($plan->included_apps))
                        <div class="pt-2">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Apps & Services Included:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($plan->included_apps as $appKey)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-700 shadow-xs">
                                        <i class="fa-solid fa-circle-check text-sky-500 text-[10px]"></i>
                                        <span>{{ ucwords(str_replace(['-', '_'], ' ', $appKey)) }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Features Highlights -->
                    @if(!empty($plan->features))
                        <div class="pt-2">
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-600 dark:text-slate-300">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-center gap-2">
                                        <i class="fa-solid fa-check text-emerald-500 text-[10px] shrink-0"></i>
                                        <span class="truncate">{!! $feature !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. Active Payment Methods Section -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Select Payment Method</h2>
                            <p class="text-xs text-slate-400">Choose your preferred payment gateway or MFS</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                        Secure 256-Bit
                    </span>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($paymentMethods as $index => $method)
                        <label for="pm_{{ $method->id }}" class="flex items-start gap-3.5 p-4 rounded-2xl border transition-all cursor-pointer method-radio-card hover:border-[#0067b8] dark:hover:border-sky-500 {{ $index === 0 ? 'border-[#0067b8] bg-sky-50/30 dark:bg-sky-950/20 shadow-xs' : 'border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-800/40' }}">
                            <div class="pt-0.5">
                                <input type="radio" 
                                       id="pm_{{ $method->id }}" 
                                       name="checkout_payment_method" 
                                       value="{{ $method->id }}" 
                                       form="checkout-form"
                                       class="w-4 h-4 text-[#0067b8] focus:ring-[#0067b8] border-slate-300 dark:border-slate-600"
                                       {{ $index === 0 ? 'checked' : '' }}
                                       onchange="updateSelectedPaymentMethod(this, '{{ addslashes($method->name) }}', '{{ addslashes($method->instruction ?? '') }}')">
                            </div>
                            
                            <!-- Logo / Fallback -->
                            <div class="w-12 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700 flex items-center justify-center p-1.5 shrink-0 overflow-hidden">
                                @if($method->logo_url)
                                    <img src="{{ $method->logo_url }}" alt="{{ $method->name }}" class="max-h-full max-w-full object-contain">
                                @elseif($method->logo && file_exists(public_path($method->logo)))
                                    <img src="{{ asset($method->logo) }}" alt="{{ $method->name }}" class="max-h-full max-w-full object-contain">
                                @else
                                    <i class="fa-solid fa-credit-card text-[#0067b8] dark:text-sky-400 text-sm"></i>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-extrabold text-slate-900 dark:text-white">{{ $method->name }}</p>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                        {{ strtoupper($method->slug) }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    {{ $method->instruction ?: 'Instant automated confirmation and receipt generation upon payment.' }}
                                </p>
                            </div>
                        </label>
                    @empty
                        <div class="p-6 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <p class="text-xs text-slate-500">No active payment gateway configured. Please contact support via WhatsApp.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. License Assignee & Account Information -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm shrink-0">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Recipient Account Details</h2>
                        <p class="text-xs text-slate-400">License will be activated on this Microsoft account</p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Recipient Full Name</label>
                        <input type="text" 
                               name="contact_name" 
                               form="checkout-form"
                               value="{{ $user->name }}" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8]">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Microsoft Account Email <span class="text-red-500">*</span></label>
                        <input type="email" 
                               name="contact_email" 
                               form="checkout-form"
                               value="{{ $user->email }}" 
                               required 
                               class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8]">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">WhatsApp / Contact Phone</label>
                        <input type="text" 
                               name="contact_phone" 
                               form="checkout-form"
                               value="{{ $user->phone }}" 
                               placeholder="+880 1XXXXXXXXX" 
                               class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8]">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 dark:text-slate-300 mb-1.5">Order Notes (Optional)</label>
                        <textarea name="notes" 
                                  form="checkout-form"
                                  rows="3"
                                  placeholder="Special activation requests, secondary email, or additional instructions..." 
                                  class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] resize-y"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN (5 Cols): Order Summary & Coupon Card -->
        <!-- ========================================== -->
        <div class="lg:col-span-5 space-y-6 sticky top-24">
            
            <!-- Order Summary Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-[#0067b8] dark:text-sky-400"></i>
                        <span>Order Summary</span>
                    </h2>
                    <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-2.5 py-0.5 rounded-full">
                        1 Item
                    </span>
                </div>

                <!-- Price Breakdown Calculations -->
                @php
                    $rawPlanPrice = $plan->numeric_price;
                @endphp

                <div class="py-5 space-y-3.5 text-xs text-slate-600 dark:text-slate-300 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-500 dark:text-slate-400">Plan: {{ $plan->name }}</span>
                        <span class="font-bold text-slate-900 dark:text-white" id="summary-subtotal">৳{{ number_format($rawPlanPrice, 2) }}</span>
                    </div>

                    <!-- Discount Row (Visible only when valid coupon applied on page) -->
                    <div id="discount-row" class="flex justify-between items-center text-emerald-600 dark:text-emerald-400 font-bold hidden">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-tag text-xs"></i>
                            <span>Discount (<span id="discount-coupon-name"></span>)</span>
                        </span>
                        <span id="summary-discount">- ৳0.00</span>
                    </div>
                </div>

                <!-- Total Amount Display -->
                <div class="py-5 flex items-baseline justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Payable</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">All taxes & CSP fees included</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tight" id="summary-total">
                            ৳{{ number_format($rawPlanPrice, 2) }}
                        </span>
                        <p class="text-[10px] text-slate-400 font-medium">BDT Currency</p>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 2. COUPON APPLICATION BOX                 -->
                <!-- ========================================== -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-ticket text-amber-500"></i>
                        <span>Apply Promo or Coupon Code</span>
                    </p>

                    <!-- Applied Coupon Badge Card -->
                    <div id="applied-coupon-container" class="hidden mb-3 p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shadow-xs">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-black font-mono text-emerald-800 dark:text-emerald-300 tracking-wider" id="applied-code-badge"></span>
                                    <span class="text-[10px] font-bold bg-emerald-200 dark:bg-emerald-900/80 text-emerald-800 dark:text-emerald-200 px-1.5 py-0.5 rounded">
                                        Applied
                                    </span>
                                </div>
                                <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-medium" id="applied-discount-text"></p>
                            </div>
                        </div>

                        <!-- Remove Coupon Button -->
                        <button type="button" 
                                onclick="removeCoupon()" 
                                class="text-xs font-bold text-red-500 hover:text-red-700 dark:hover:text-red-400 p-1.5 hover:bg-red-50 dark:hover:bg-red-950/60 rounded-xl transition-colors cursor-pointer" 
                                title="Remove Coupon">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>

                    <!-- Coupon Input Form -->
                    <div id="coupon-input-wrapper">
                        <form id="coupon-form" onsubmit="applyCoupon(event)" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-ticket text-xs"></i>
                                </span>
                                <input type="text" 
                                       id="coupon_code_input" 
                                       name="code" 
                                       placeholder="e.g. WELCOME10, EID500" 
                                       class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono font-bold uppercase text-slate-900 dark:text-white placeholder:font-sans placeholder:normal-case placeholder:font-normal focus:ring-2 focus:ring-[#0067b8]">
                            </div>
                            <button type="submit" 
                                    id="coupon-apply-btn"
                                    class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs transition-all shrink-0 cursor-pointer active:scale-95 flex items-center gap-1.5">
                                <span>Apply</span>
                            </button>
                        </form>
                        <p id="coupon-error-msg" class="text-[11px] font-semibold text-red-500 dark:text-red-400 mt-1.5 hidden"></p>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 3. MAIN CHECKOUT PROCEED BUTTON           -->
                <!-- ========================================== -->
                <form id="checkout-form" action="{{ route('user.checkout.process') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <input type="hidden" name="payment_method_id" id="form_payment_method_id" value="{{ $paymentMethods->first()->id ?? 1 }}">
                    <input type="hidden" name="coupon_code" id="form_coupon_code" value="">

                    <button type="submit" 
                            id="checkout-submit-btn"
                            class="w-full py-4 px-6 rounded-2xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-extrabold text-sm sm:text-base flex items-center justify-center gap-2.5 transition-all shadow-lg shadow-[#0067b8]/25 hover:shadow-xl hover:shadow-[#0067b8]/30 active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-lock text-sm" id="checkout-btn-icon"></i>
                        <span id="checkout-btn-text">Proceed to Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs" id="checkout-btn-arrow"></i>
                    </button>
                </form>

                <!-- Guarantee & Security Notes -->
                <div class="mt-5 space-y-2 text-[11px] text-slate-400">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>100% Genuine Microsoft Partner license activation</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-500"></i>
                        <span>Instant license provisioning upon payment confirmation</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-headset text-sky-500"></i>
                        <span>24/7 dedicated support via Dhaka helpline & WhatsApp</span>
                    </div>
                </div>

            </div>

            <!-- WhatsApp Quick Assist Helper Box -->
            <div class="bg-gradient-to-r from-emerald-950/40 to-slate-900 rounded-3xl border border-emerald-900/60 p-5 text-white flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">Have questions before checkout?</p>
                        <p class="text-[11px] text-emerald-300">Chat directly with our Dhaka CSP Desk</p>
                    </div>
                </div>
                <a href="https://wa.me/8801342325558?text={{ urlencode('Hello, I am at checkout for ' . $plan->name . '. I need assistance.') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shrink-0 transition-all">
                    Chat Now
                </a>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    // Update Radio payment method visual state and form hidden input
    function updateSelectedPaymentMethod(radioEl, name, instruction) {
        document.getElementById('form_payment_method_id').value = radioEl.value;

        document.querySelectorAll('.method-radio-card').forEach(card => {
            card.classList.remove('border-[#0067b8]', 'bg-sky-50/30', 'dark:bg-sky-950/20', 'shadow-xs');
            card.classList.add('border-slate-200/90', 'dark:border-slate-800', 'bg-white', 'dark:bg-slate-800/40');
        });

        const parentCard = radioEl.closest('.method-radio-card');
        if (parentCard) {
            parentCard.classList.remove('border-slate-200/90', 'dark:border-slate-800', 'bg-white', 'dark:bg-slate-800/40');
            parentCard.classList.add('border-[#0067b8]', 'bg-sky-50/30', 'dark:bg-sky-950/20', 'shadow-xs');
        }
    }

    // Apply Coupon via AJAX for the current page only
    async function applyCoupon(event) {
        event.preventDefault();
        const input = document.getElementById('coupon_code_input');
        const code = input.value.trim();
        const errorEl = document.getElementById('coupon-error-msg');
        const applyBtn = document.getElementById('coupon-apply-btn');

        if (!code) {
            errorEl.textContent = 'Please enter a valid coupon code.';
            errorEl.classList.remove('hidden');
            return;
        }

        errorEl.classList.add('hidden');
        applyBtn.disabled = true;
        applyBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

        try {
            const response = await fetch("{{ route('user.checkout.apply-coupon') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    code: code,
                    plan_id: "{{ $plan->id }}"
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Set hidden form coupon value
                document.getElementById('form_coupon_code').value = data.coupon.code;

                // Update UI state
                document.getElementById('coupon-input-wrapper').classList.add('hidden');
                document.getElementById('applied-coupon-container').classList.remove('hidden');
                document.getElementById('applied-code-badge').textContent = data.coupon.code;
                document.getElementById('applied-discount-text').textContent = data.coupon.formatted;

                // Update summary calculations
                document.getElementById('discount-row').classList.remove('hidden');
                document.getElementById('discount-coupon-name').textContent = data.coupon.code;
                document.getElementById('summary-discount').textContent = '- ৳' + Number(data.discount_amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                document.getElementById('summary-total').textContent = '৳' + Number(data.final_total).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

                // If 100% Free
                const submitBtn = document.getElementById('checkout-submit-btn');
                const btnIcon = document.getElementById('checkout-btn-icon');
                const btnText = document.getElementById('checkout-btn-text');

                if (data.final_total <= 0) {
                    submitBtn.classList.remove('bg-[#0067b8]', 'hover:bg-[#005a9e]', 'shadow-[#0067b8]/25', 'hover:shadow-[#0067b8]/30');
                    submitBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-600/25', 'hover:shadow-emerald-600/30');
                    btnIcon.className = 'fa-solid fa-gift text-sm';
                    btnText.textContent = 'Claim 100% Free License';
                } else {
                    submitBtn.classList.add('bg-[#0067b8]', 'hover:bg-[#005a9e]', 'shadow-[#0067b8]/25', 'hover:shadow-[#0067b8]/30');
                    submitBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-600/25', 'hover:shadow-emerald-600/30');
                    btnIcon.className = 'fa-solid fa-lock text-sm';
                    btnText.textContent = 'Proceed to Checkout';
                }
            } else {
                errorEl.textContent = data.message || 'Invalid coupon code.';
                errorEl.classList.remove('hidden');
            }
        } catch (error) {
            errorEl.textContent = 'An error occurred while validating coupon.';
            errorEl.classList.remove('hidden');
        } finally {
            applyBtn.disabled = false;
            applyBtn.innerHTML = '<span>Apply</span>';
        }
    }

    // Remove Coupon on current page
    function removeCoupon() {
        document.getElementById('form_coupon_code').value = '';
        document.getElementById('applied-coupon-container').classList.add('hidden');
        document.getElementById('coupon-input-wrapper').classList.remove('hidden');
        document.getElementById('coupon_code_input').value = '';
        document.getElementById('discount-row').classList.add('hidden');
        
        // Reset Total to base plan price
        const baseTotal = {{ $plan->numeric_price }};
        document.getElementById('summary-total').textContent = '৳' + Number(baseTotal).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        const submitBtn = document.getElementById('checkout-submit-btn');
        const btnIcon = document.getElementById('checkout-btn-icon');
        const btnText = document.getElementById('checkout-btn-text');

        submitBtn.classList.add('bg-[#0067b8]', 'hover:bg-[#005a9e]', 'shadow-[#0067b8]/25', 'hover:shadow-[#0067b8]/30');
        submitBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-600/25', 'hover:shadow-emerald-600/30');
        btnIcon.className = 'fa-solid fa-lock text-sm';
        btnText.textContent = 'Proceed to Checkout';
    }
</script>
@endpush
