@extends('layouts.admin.admin')

@section('title', 'Edit ' . $plan->name . ' | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.plans.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        Pricing Plans
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Edit Plan
    </span>
@endsection

@section('content')

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-5 py-4 rounded-2xl">
            <p class="font-bold text-xs sm:text-sm">Please fix the following issues:</p>
            <ul class="list-disc list-inside mt-1 text-xs space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden max-w-4xl">
        
        <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Edit {{ $plan->name }}</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Update pricing rates, features checklist, buttons & app badges.</p>
            </div>
        </div>

        <form action="{{ route('admin.plans.update', $plan) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Name & Badge -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Plan Title / Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $plan->name) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Highlight Badge <span class="text-slate-400 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="text" name="badge" value="{{ old('badge', $plan->badge) }}" placeholder="e.g. Most Popular" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>
            </div>

            <!-- 2. Pricing & Currency Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        BDT Price (Text) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="price_bdt" value="{{ old('price_bdt', $plan->price_bdt) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Billing Period <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="billing_period" value="{{ old('billing_period', $plan->billing_period) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        USD Reference <span class="text-slate-400 font-normal lowercase">(optional)</span>
                    </label>
                    <input type="text" name="price_usd" value="{{ old('price_usd', $plan->price_usd) }}" placeholder="e.g. $99.99/yr" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>
            </div>

            <!-- 3. Button Action & Link -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        CTA Button Text <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="button_text" value="{{ old('button_text', $plan->button_text) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Button Link / WhatsApp URL
                    </label>
                    <input type="text" name="button_url" value="{{ old('button_url', $plan->button_url) }}" placeholder="https://..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                </div>
            </div>

            <!-- 4. Terms Subtext -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    Terms & Renewal Notice
                </label>
                <input type="text" name="terms_text" value="{{ old('terms_text', $plan->terms_text) }}" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
            </div>

            <!-- 5. Features Checklist -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    Features Header & List <span class="text-red-500">*</span>
                </label>
                <input type="text" name="features_heading" value="{{ old('features_heading', $plan->features_heading) }}" placeholder="e.g. Everything in Basic, plus:" class="w-full px-4 py-2.5 mb-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none" />
                
                <p class="text-[11px] text-slate-400 mb-1.5 font-medium">Enter 1 feature per line (HTML tags like &lt;strong&gt; are supported):</p>
                <textarea name="features" rows="7" required class="w-full p-4 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-2xl text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</textarea>
            </div>

            <!-- 6. Included Apps Icons Selection -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">
                    Select Included Microsoft Apps Logos:
                </label>
                <p class="text-[11px] text-slate-400 mb-3">Click on the apps to select/unselect which icons will appear at the bottom of the pricing card:</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                    @php
                        $selectedApps = old('included_apps', $plan->included_apps ?? []);
                    @endphp
                    @foreach($availableApps as $key => $title)
                        @php
                            $isSelected = in_array($key, $selectedApps);
                        @endphp
                        <label class="relative flex flex-col items-center justify-center p-3 rounded-2xl border-2 cursor-pointer transition-all duration-150 select-none group {{ $isSelected ? 'border-[#0067b8] bg-sky-50/80 dark:bg-sky-950/50 shadow-xs' : 'border-slate-200 dark:border-slate-700 bg-slate-50/40 dark:bg-slate-800/40 hover:border-slate-300 dark:hover:border-slate-600' }}">
                            <input type="checkbox" name="included_apps[]" value="{{ $key }}" {{ $isSelected ? 'checked' : '' }} class="app-checkbox hidden" onchange="syncAppCard(this)" />
                            
                            <!-- Check Indicator Badge -->
                            <div class="check-badge absolute top-1.5 right-1.5 w-4 h-4 rounded-full flex items-center justify-center text-[9px] {{ $isSelected ? 'bg-[#0067b8] text-white' : 'bg-slate-200 dark:bg-slate-700 text-transparent' }} transition-colors">
                                <i class="fa-solid fa-check"></i>
                            </div>

                            <img src="{{ asset('assets/img/products/' . $key . '.png') }}" class="w-8 h-8 object-contain mb-1.5 transition-transform group-hover:scale-105" alt="{{ $title }}" onerror="this.style.display='none'" />
                            <span class="text-[11px] font-bold text-slate-800 dark:text-slate-200 text-center leading-tight">{{ $title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 7. Options: Featured & Active & Sort Order -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0067b8] focus:ring-[#0067b8]" />
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Featured (Blue Border Card)</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0067b8] focus:ring-[#0067b8]" />
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active (Visible on Website)</span>
                </label>

                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Sort Order:</span>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" class="w-20 px-3 py-1.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-bold outline-none" />
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.plans.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-7 py-3 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all flex items-center gap-2 active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Update Plan</span>
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    function syncAppCard(checkbox) {
        const label = checkbox.closest('label');
        const badge = label.querySelector('.check-badge');
        if (checkbox.checked) {
            label.classList.add('border-[#0067b8]', 'bg-sky-50/80', 'dark:bg-sky-950/50', 'shadow-xs');
            label.classList.remove('border-slate-200', 'dark:border-slate-700', 'bg-slate-50/40', 'dark:bg-slate-800/40');
            badge.classList.add('bg-[#0067b8]', 'text-white');
            badge.classList.remove('bg-slate-200', 'dark:bg-slate-700', 'text-transparent');
        } else {
            label.classList.remove('border-[#0067b8]', 'bg-sky-50/80', 'dark:bg-sky-950/50', 'shadow-xs');
            label.classList.add('border-slate-200', 'dark:border-slate-700', 'bg-slate-50/40', 'dark:bg-slate-800/40');
            badge.classList.remove('bg-[#0067b8]', 'text-white');
            badge.classList.add('bg-slate-200', 'dark:bg-slate-700', 'text-transparent');
        }
    }
</script>
@endpush
