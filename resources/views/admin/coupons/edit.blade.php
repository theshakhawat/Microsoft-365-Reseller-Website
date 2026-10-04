@extends('layouts.admin.admin')

@section('title', 'Edit Coupon: ' . $coupon->code . ' | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.coupons.index') }}" class="hover:text-[#0067b8] transition-colors">Coupons & Discounts</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Edit ({{ $coupon->code }})</span>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Flash Errors -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 shadow-xs">
            <div class="flex items-center gap-3 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">Please correct the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <span>Edit Coupon: <span class="font-mono text-[#0067b8] dark:text-sky-400">{{ $coupon->code }}</span></span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Update coupon code parameters, change discount values, or adjust expiration date.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Usage Banner -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800/80 p-5 rounded-3xl border border-blue-100 dark:border-slate-700/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#0067b8] text-white flex items-center justify-center text-xl shadow-md shadow-[#0067b8]/20 shrink-0">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Usage Analytics</p>
                <p class="text-sm font-black text-slate-900 dark:text-white mt-0.5">
                    Used <span class="text-[#0067b8] dark:text-sky-400">{{ $coupon->used_count }}</span> times
                    @if($coupon->max_uses)
                        out of <span class="text-slate-700 dark:text-slate-300">{{ $coupon->max_uses }}</span> maximum limit
                    @else
                        (Unlimited)
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right sm:block hidden">
                <p class="text-[11px] text-slate-400 font-bold uppercase">Current Status</p>
                <p class="text-xs font-black {{ $coupon->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500' }}">
                    {{ $coupon->is_active ? 'Active & Ready' : 'Disabled / Inactive' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- 1. Basic Coupon Information -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-tag text-[#0067b8] dark:text-sky-400"></i>
                    1. Coupon Information
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Coupon Code -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Coupon Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="code" 
                           value="{{ old('code', $coupon->code) }}" 
                           required 
                           placeholder="e.g. SAVE20, EID500" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold uppercase text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Codes are automatically uppercase and spaces are removed.</p>
                </div>

                <!-- Campaign / Coupon Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Campaign / Coupon Title
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $coupon->name) }}" 
                           placeholder="e.g. Eid Mega Sale 2026" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Internal title or public label for this promotion.</p>
                </div>

                <!-- Description -->
                <div class="col-span-full">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Description / Terms (Optional)
                    </label>
                    <textarea name="description" 
                              rows="2" 
                              placeholder="e.g. Applicable only on yearly subscriptions. One use per customer." 
                              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">{{ old('description', $coupon->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- 2. Discount Type & Value -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-percent text-emerald-600 dark:text-emerald-400"></i>
                    2. Discount Settings
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Discount Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Discount Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                            <input type="radio" name="discount_type" value="percentage" {{ old('discount_type', $coupon->discount_type) === 'percentage' ? 'checked' : '' }} onchange="toggleDiscountType(this.value)" class="text-[#0067b8] focus:ring-[#0067b8]">
                            <div>
                                <p class="text-xs font-black text-slate-900 dark:text-white">Percentage (%)</p>
                                <p class="text-[10px] text-slate-400">e.g. 10%, 25% off</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-2xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                            <input type="radio" name="discount_type" value="fixed" {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'checked' : '' }} onchange="toggleDiscountType(this.value)" class="text-[#0067b8] focus:ring-[#0067b8]">
                            <div>
                                <p class="text-xs font-black text-slate-900 dark:text-white">Flat Amount (৳)</p>
                                <p class="text-[10px] text-slate-400">e.g. ৳500 flat off</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Discount Value -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        <span id="discountValueLabel">Discount Rate (%)</span> <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               step="0.01" 
                               name="discount_value" 
                               value="{{ old('discount_value', $coupon->discount_value) }}" 
                               required 
                               placeholder="e.g. 20" 
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                        <span id="discountUnit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">
                            %
                        </span>
                    </div>
                    <p id="discountHelpText" class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Enter percentage value (1 to 100).</p>
                </div>

                <!-- Minimum Order Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Minimum Order Amount (৳) <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">৳</span>
                        <input type="number" 
                               step="0.01" 
                               name="min_order_amount" 
                               value="{{ old('min_order_amount', $coupon->min_order_amount) }}" 
                               placeholder="e.g. 1500" 
                               class="w-full pl-8 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Leave blank if no minimum purchase is required.</p>
                </div>

                <!-- Maximum Discount Amount (Cap) -->
                <div id="maxDiscountContainer">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Maximum Discount Cap (৳) <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">৳</span>
                        <input type="number" 
                               step="0.01" 
                               name="max_discount_amount" 
                               value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" 
                               placeholder="e.g. 500" 
                               class="w-full pl-8 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Cap the maximum discount amount for percentage coupons.</p>
                </div>

            </div>
        </div>

        <!-- 3. Dates & Usage Limits -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-purple-600 dark:text-purple-400"></i>
                    3. Validity & Usage Limits
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Start Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Start Date & Time <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                    </label>
                    <input type="datetime-local" 
                           name="start_date" 
                           value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Leave empty to keep active immediately.</p>
                </div>

                <!-- Expire Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Expiry Date & Time <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                    </label>
                    <input type="datetime-local" 
                           name="expire_date" 
                           value="{{ old('expire_date', $coupon->expire_date ? $coupon->expire_date->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Leave empty for lifetime validity without expiration.</p>
                </div>

                <!-- Max Total Uses -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Total Maximum Uses <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                    </label>
                    <input type="number" 
                           name="max_uses" 
                           value="{{ old('max_uses', $coupon->max_uses) }}" 
                           placeholder="e.g. 100" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Total times this coupon can be redeemed. Leave blank for unlimited.</p>
                </div>

                <!-- Max Uses Per User -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Max Uses Per Person <span class="text-slate-400 text-[10px] font-normal">(Default: 1)</span>
                    </label>
                    <input type="number" 
                           name="max_uses_per_user" 
                           value="{{ old('max_uses_per_user', $coupon->max_uses_per_user ?? 1) }}" 
                           min="1" 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">How many times each customer can use this coupon.</p>
                </div>

            </div>
        </div>

        <!-- 4. Status Toggle -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white">Active Status</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Enable or disable this coupon code instantly.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0067b8]"></div>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/25 active:scale-95 transition-all cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Update Coupon</span>
            </button>
        </div>

    </form>

</div>

<script>
    function toggleDiscountType(type) {
        const label = document.getElementById('discountValueLabel');
        const unit = document.getElementById('discountUnit');
        const help = document.getElementById('discountHelpText');
        const maxCap = document.getElementById('maxDiscountContainer');

        if (type === 'percentage') {
            label.textContent = 'Discount Rate (%)';
            unit.textContent = '%';
            help.textContent = 'Enter percentage value (1 to 100).';
            maxCap.style.display = 'block';
        } else {
            label.textContent = 'Flat Discount Amount (৳)';
            unit.textContent = '৳';
            help.textContent = 'Enter fixed amount in BDT.';
            maxCap.style.display = 'none';
        }
    }

    // Init discount type display on page load
    document.addEventListener('DOMContentLoaded', () => {
        const selectedType = document.querySelector('input[name="discount_type"]:checked');
        if (selectedType) {
            toggleDiscountType(selectedType.value);
        }
    });
</script>
@endsection
