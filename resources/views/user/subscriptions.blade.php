@extends('layouts.user.user')

@section('title', 'My Subscriptions & Microsoft 365 Licenses | Microsoft Office Club')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">My Subscriptions</span>
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

    @if(session('info'))
    <div class="mb-6 p-4 rounded-2xl bg-sky-50 dark:bg-sky-950/60 border border-sky-200 dark:border-sky-800 text-sky-800 dark:text-sky-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-info text-base text-[#0067b8] dark:text-sky-400"></i>
            <span class="font-bold">{{ session('info') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-[#0067b8] hover:text-sky-800 dark:text-sky-400">
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

    <div class="space-y-6 sm:space-y-8">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-[#072448] to-[#0067b8] text-white p-6 sm:p-8 rounded-3xl relative overflow-hidden shadow-md">
            <div class="absolute -right-12 -bottom-12 w-60 h-60 bg-sky-400/20 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/10 backdrop-blur-md mb-2 text-sky-200">
                        <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                        <span>CSP Authorized Licenses</span>
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Active Subscriptions</h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                        View genuine Microsoft 365 licenses assigned to your account, manage 1TB OneDrive cloud storage, and download Office apps.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('user.plans') }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-900 font-bold text-xs flex items-center gap-2 shadow-sm transition-all active:scale-95">
                        <i class="fa-solid fa-cart-shopping text-[#0067b8]"></i>
                        <span>Order New License</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Subscriptions Grid -->
        <div class="space-y-6">
            @forelse($subscriptions as $sub)
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <div class="flex items-center gap-2.5">
                                @if($sub->status === 'active')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Active License</span>
                                    </span>
                                @elseif($sub->status === 'suspended')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                        Suspended
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                @endif
                                <span class="text-xs font-mono font-bold text-slate-400">#{{ $sub->subscription_key }}</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-2">
                                {{ $sub->plan_name }}
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Linked Microsoft ID: <span class="font-bold text-[#0067b8] dark:text-sky-400">{{ $sub->license_email }}</span>
                            </p>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-xl inline-block">
                                Validity: {{ $sub->starts_at?->format('M d, Y') }} - {{ $sub->expires_at?->format('M d, Y') }}
                            </span>
                            @if($sub->is_active)
                                <p class="text-xs text-emerald-600 font-bold mt-1.5">
                                    <i class="fa-solid fa-clock-rotate-left"></i> {{ $sub->remaining_days }} Days Remaining
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Included Apps & Cloud Storage -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Left 2 Cols: Included Apps -->
                        <div class="md:col-span-2">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Included Apps & Software</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#185abd] text-white flex items-center justify-center font-bold text-xs">W</div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">Word</p><p class="text-[10px] text-slate-400">Desktop & Web</p></div>
                                </div>
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#107c41] text-white flex items-center justify-center font-bold text-xs">X</div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">Excel</p><p class="text-[10px] text-slate-400">Desktop & Web</p></div>
                                </div>
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#c43e1c] text-white flex items-center justify-center font-bold text-xs">P</div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">PowerPoint</p><p class="text-[10px] text-slate-400">Desktop & Web</p></div>
                                </div>
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#0078d4] text-white flex items-center justify-center font-bold text-xs">O</div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">Outlook</p><p class="text-[10px] text-slate-400">50GB Mailbox</p></div>
                                </div>
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-purple-500 to-pink-500 text-white flex items-center justify-center font-bold text-xs">
                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                    </div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">Copilot AI</p><p class="text-[10px] text-slate-400">Integrated</p></div>
                                </div>
                                <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-sky-500 text-white flex items-center justify-center font-bold text-xs">
                                        <i class="fa-solid fa-cloud"></i>
                                    </div>
                                    <div><p class="text-xs font-bold text-slate-900 dark:text-white">OneDrive</p><p class="text-[10px] text-slate-400">{{ $sub->cloud_storage }}</p></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right 1 Col: Direct Office.com Sign In -->
                        <div class="p-5 rounded-2xl bg-sky-50/50 dark:bg-sky-950/30 border border-sky-100 dark:border-sky-900/50 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <i class="fa-solid fa-download text-[#0067b8] dark:text-sky-400"></i>
                                    <span>Download & Sign In</span>
                                </h4>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                    Log in to portal.office.com using <span class="font-semibold">{{ $sub->license_email }}</span> to install desktop apps on PC/Mac.
                                </p>
                            </div>
                            <div class="mt-4 space-y-2">
                                <a href="https://portal.office.com" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs flex items-center justify-center gap-1.5 transition-all">
                                    <span>Sign in to Office.com</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I need help activating license: ' . $sub->license_email) }}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center justify-center gap-1.5 transition-all">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span>Help Activating License</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8">
                    <div class="w-16 h-16 rounded-3xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">No Active Subscriptions Yet</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-md mx-auto mt-1 mb-6">
                        Once you order a Microsoft 365 license and payment is verified, your active subscription details and 1TB cloud storage will appear here.
                    </p>
                    <a href="{{ route('user.plans') }}" class="px-6 py-3 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs inline-flex items-center gap-2 shadow-md shadow-[#0067b8]/20 transition-all">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Explore Pricing Plans</span>
                    </a>
                </div>
            @endforelse
        </div>

    </div>

@endsection
