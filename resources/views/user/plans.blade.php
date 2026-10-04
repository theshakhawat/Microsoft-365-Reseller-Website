@extends('layouts.user.user')

@section('title', 'Pricing Plans & Subscriptions | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Pricing Plans</span>
@endsection

@section('content')

    <!-- Page Title Banner -->
    <div class="bg-gradient-to-r from-[#0067b8] to-sky-600 rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-lg shadow-[#0067b8]/20">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md mb-3">
                <i class="fa-solid fa-fire text-amber-300"></i>
                Official Subscriptions
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Microsoft 365 Pricing Plans</h1>
            <p class="text-xs sm:text-sm text-sky-100 mt-2 leading-relaxed">
                Explore genuine Microsoft 365 licenses tailored for individuals, families, and business organizations. Get 1TB cloud storage, full Office app suite, and 24/7 dedicated local support.
            </p>
        </div>
    </div>

    <!-- Value Props Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900 dark:text-white">100% Genuine License</p>
                <p class="text-[11px] text-slate-400">Direct Microsoft CSP Partner</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900 dark:text-white">Instant Activation</p>
                <p class="text-[11px] text-slate-400">Setup on your personal email</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base shrink-0">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900 dark:text-white">24/7 Local Support</p>
                <p class="text-[11px] text-slate-400">WhatsApp & Phone assistance</p>
            </div>
        </div>
    </div>

    <!-- Plans Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border {{ $plan->is_featured ? 'border-2 border-[#0067b8] dark:border-sky-500 shadow-xl shadow-[#0067b8]/10' : 'border-slate-200/90 dark:border-slate-800 shadow-xs hover:shadow-md' }} p-6 sm:p-7 flex flex-col justify-between relative transition-all">
                
                <div>
                    <!-- Header / Badge -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        @if($plan->badge)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $plan->is_featured ? 'bg-[#0067b8] text-white shadow-xs' : 'bg-sky-50 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 border border-sky-200 dark:border-sky-800' }}">
                                <i class="fa-solid fa-fire text-amber-300 text-[10px]"></i>
                                {{ $plan->badge }}
                            </span>
                        @else
                            <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                Subscription Plan
                            </span>
                        @endif

                        @if($plan->is_featured)
                            <span class="text-[10px] font-bold text-amber-500 flex items-center gap-1">
                                <i class="fa-solid fa-star text-[10px]"></i> Popular
                            </span>
                        @endif
                    </div>

                    <!-- Plan Title -->
                    <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ $plan->name }}
                    </h3>

                    <!-- Price Display -->
                    <div class="mt-3 mb-5">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ $plan->price_bdt }}
                            </span>
                            <span class="text-xs font-bold text-slate-400">
                                / {{ $plan->billing_period }}
                            </span>
                        </div>
                        @if($plan->price_usd)
                            <p class="text-xs text-slate-400 mt-0.5">Approx. {{ $plan->price_usd }}</p>
                        @endif
                    </div>

                    <!-- Included Apps Pills -->
                    @if(!empty($plan->included_apps))
                        <div class="mb-5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Apps & Services Included:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($plan->included_apps as $appKey)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        <i class="fa-solid fa-circle-check text-sky-500 text-[10px]"></i>
                                        <span>{{ ucwords(str_replace(['-', '_'], ' ', $appKey)) }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Features List -->
                    <div class="border-t border-slate-100 dark:border-slate-800 pt-4 mb-6">
                        <p class="text-xs font-black text-slate-900 dark:text-white mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-list-check text-[#0067b8] dark:text-sky-400"></i>
                            <span>{{ $plan->features_heading ?: 'What\'s Included:' }}</span>
                        </p>
                        <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-300">
                            @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[9px]"></i>
                                    </div>
                                    <span class="leading-snug">{!! $feature !!}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- CTA Button & Terms -->
                @php
                    $planCheck = Auth::user()->canPurchasePlan($plan);
                @endphp
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-2">
                    @if($planCheck['allowed'])
                        <a href="{{ route('user.checkout', $plan->id) }}" 
                           class="w-full py-3 px-4 rounded-2xl text-xs sm:text-sm font-bold text-center flex items-center justify-center gap-2 transition-all cursor-pointer {{ $planCheck['is_upgrade'] ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white shadow-md shadow-emerald-600/25' : ($plan->is_featured ? 'bg-[#0067b8] hover:bg-[#005a9e] text-white shadow-md shadow-[#0067b8]/25 hover:shadow-lg active:scale-95' : 'bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white active:scale-95') }}">
                            <span>{{ $planCheck['is_upgrade'] ? 'Upgrade to ' . $plan->name : ($plan->button_text ?: 'Buy Now') }}</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        @if($planCheck['is_upgrade'])
                            <p class="text-[10px] text-center text-emerald-600 dark:text-emerald-400 font-semibold">
                                <i class="fa-solid fa-clock-rotate-left mr-1"></i>Remaining days of Basic plan will be added!
                            </p>
                        @endif
                    @else
                        <div class="w-full py-3 px-4 rounded-2xl text-xs font-bold text-center flex items-center justify-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>{{ str_contains(strtolower($plan->name), 'basic') ? 'Downgrade Not Allowed' : 'Current Active Plan' }}</span>
                        </div>
                    @endif

                    @if($plan->terms_text)
                        <p class="text-[10px] text-center text-slate-400 dark:text-slate-500">
                            {{ $plan->terms_text }}
                        </p>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl text-slate-400 mx-auto mb-3">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">No Active Plans Available</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">
                    New pricing plans will be listed soon. Please check back later.
                </p>
                <a href="https://wa.me/8801342325558" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Contact on WhatsApp</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Need Help / Custom Quote Banner -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1 max-w-xl">
            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">Need a Custom Enterprise or Multi-Seat Plan?</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                If you need custom bulk licenses for your school, college, or organization, our team is ready to help with custom invoicing and setup.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="https://wa.me/8801342325558" target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-2 shadow-md shadow-emerald-600/20 transition-all">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Chat on WhatsApp</span>
            </a>
        </div>
    </div>

@endsection
