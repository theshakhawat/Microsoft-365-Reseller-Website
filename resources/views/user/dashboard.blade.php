@extends('layouts.user.user')

@section('title', 'User Portal Dashboard - Microsoft Office Club')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Dashboard</span>
@endsection

@section('content')
<div class="space-y-6 sm:space-y-8">

    <!-- ================================================================= -->
    <!-- 1. MODERN WELCOME HERO BANNER                                     -->
    <!-- ================================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-[#072448] to-[#0067b8] text-white p-6 sm:p-9 shadow-lg">
        <!-- Decorative Glow Background Circles -->
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-sky-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-16 w-64 h-64 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-sky-200 border border-white/15 mb-3">
                    @if($activeSubscription)
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Active Microsoft 365 License</span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span>Account Registered • No Active Plan</span>
                    @endif
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Hello, {{ $user->name }}!
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                    Welcome to your Microsoft 365 cloud management portal. Manage genuine licenses, access official desktop software, and monitor 1 TB OneDrive storage.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                @if(!$activeSubscription)
                    <a href="{{ route('user.plans') }}" class="bg-white hover:bg-slate-100 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                        <i class="fa-solid fa-cart-shopping text-xs text-[#0067b8]"></i>
                        <span>Order New Plan</span>
                    </a>
                @else
                    <a href="{{ route('user.subscriptions') }}" class="bg-white hover:bg-slate-100 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                        <i class="fa-solid fa-shield-halved text-xs text-[#0067b8]"></i>
                        <span>Manage Subscription</span>
                    </a>
                    <a href="https://portal.office.com" target="_blank" class="bg-sky-500/30 hover:bg-sky-500/40 text-white font-bold px-4 py-2.5 rounded-xl text-xs border border-sky-400/40 flex items-center gap-2 transition-all active:scale-95">
                        <span>Office.com Portal</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                @endif
                <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello, I need assistance with Microsoft Office Club.')) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>WhatsApp Desk</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 2. TOP 4 DYNAMIC KPI STAT METRIC CARDS                            -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Stat 1: License Status -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex items-center gap-4 transition-all hover:border-[#0067b8]/40 dark:hover:border-sky-500/40">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-key"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">License Status</p>
                <p class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white mt-0.5 truncate">
                    {{ $activeSubscription ? ($activeSubscription->plan_name ?: 'Microsoft 365') : 'No Active Plan' }}
                </p>
                @if($activeSubscription)
                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                        <i class="fa-solid fa-circle-check text-[10px]"></i> Active & CSP Linked
                    </span>
                @else
                    <span class="text-[11px] text-slate-400 font-semibold flex items-center gap-1 mt-0.5">
                        <i class="fa-solid fa-circle-info text-[10px]"></i> Ready to Subscribe
                    </span>
                @endif
            </div>
        </div>

        <!-- Stat 2: Cloud Storage -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex items-center gap-4 transition-all hover:border-purple-500/40">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-cloud"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cloud Storage</p>
                <p class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">
                    {{ $activeSubscription ? $activeSubscription->cloud_storage : '0 GB' }}
                </p>
                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-1.5 overflow-hidden">
                    <div class="bg-purple-500 h-1.5 rounded-full {{ $activeSubscription ? 'w-[20%]' : 'w-0' }}"></div>
                </div>
            </div>
        </div>

        <!-- Stat 3: Orders & Spending -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex items-center gap-4 transition-all hover:border-emerald-500/40">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Orders</p>
                <p class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">
                    {{ $stats['total_orders'] }} {{ Str::plural('Order', $stats['total_orders']) }}
                </p>
                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                    ৳{{ number_format($stats['total_spent'], 2) }} Paid Total
                </span>
            </div>
        </div>

        <!-- Stat 4: Support & Tickets -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex items-center gap-4 transition-all hover:border-amber-500/40">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Help Desk</p>
                <p class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">
                    {{ $stats['open_tickets'] }} Open {{ Str::plural('Ticket', $stats['open_tickets']) }}
                </p>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                    {{ $stats['unread_notifs'] }} unread notifications
                </span>
            </div>
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 3. MAIN CONTENT 2-COLUMN GRID                                     -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ============================================================= -->
        <!-- LEFT COLUMN (2 Cols): Active License, Apps & Quick Setup      -->
        <!-- ============================================================= -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- 3.1 ACTIVE LICENSE / SUBSCRIPTION OVERVIEW -->
            @if($activeSubscription)
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-2.5 py-1 rounded-full">
                                Official Microsoft Partner License
                            </span>
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mt-2">
                                {{ $activeSubscription->plan_name }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                License Account: <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $activeSubscription->license_email ?: $user->email }}</span>
                            </p>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-3.5 py-2 rounded-xl inline-block">
                                <i class="fa-solid fa-clock text-amber-500 mr-1.5"></i>
                                {{ $activeSubscription->remaining_days }} Days Validity Left
                            </span>
                        </div>
                    </div>

                    <!-- Key Metadata & Progress Bar -->
                    <div class="mt-5 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">Subscription ID:</span>
                                <span class="font-mono font-bold text-slate-800 dark:text-slate-200 bg-white dark:bg-slate-900 px-2 py-0.5 rounded-md border border-slate-200 dark:border-slate-700">
                                    {{ $activeSubscription->subscription_key }}
                                </span>
                            </div>
                            <div class="text-slate-500 dark:text-slate-400 text-[11px]">
                                Cycle: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $activeSubscription->starts_at ? $activeSubscription->starts_at->format('M d, Y') : 'Active' }}</span> &rarr; 
                                <span class="font-bold text-slate-700 dark:text-slate-300">{{ $activeSubscription->expires_at ? $activeSubscription->expires_at->format('M d, Y') : 'Perpetual' }}</span>
                            </div>
                        </div>

                        <!-- Remaining Days Visual Bar -->
                        <div class="mt-3">
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-bold mb-1">
                                <span>Validity Progress</span>
                                <span>{{ $activeSubscription->remaining_days }} Days Remaining</span>
                            </div>
                            @php
                                $totalCycleDays = 365;
                                $remDays = max(0, (int) $activeSubscription->remaining_days);
                                $percent = min(100, max(5, round(($remDays / $totalCycleDays) * 100)));
                            @endphp
                            <div class="w-full bg-slate-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-500 to-[#0067b8] h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Included Office Apps Grid -->
                    <div class="mt-6" id="apps-suite">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Included Apps & Premium Cloud Features</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                            
                            <!-- Word -->
                            <a href="https://word.office.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-[#185abd] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    W
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Word</p>
                                    <p class="text-[11px] text-slate-400">Desktop & Web</p>
                                </div>
                            </a>

                            <!-- Excel -->
                            <a href="https://excel.office.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-[#107c41] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    X
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Excel</p>
                                    <p class="text-[11px] text-slate-400">Full Premium</p>
                                </div>
                            </a>

                            <!-- PowerPoint -->
                            <a href="https://powerpoint.office.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-[#c43e1c] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    P
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">PowerPoint</p>
                                    <p class="text-[11px] text-slate-400">Templates & AI</p>
                                </div>
                            </a>

                            <!-- Outlook -->
                            <a href="https://outlook.office.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-[#0078d4] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    O
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Outlook</p>
                                    <p class="text-[11px] text-slate-400">Ad-Free Mail</p>
                                </div>
                            </a>

                            <!-- OneDrive -->
                            <a href="https://onedrive.live.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-cloud text-xs"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">OneDrive</p>
                                    <p class="text-[11px] text-slate-400">1 TB Cloud</p>
                                </div>
                            </a>

                            <!-- Copilot AI -->
                            <a href="https://copilot.microsoft.com" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/60 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center gap-3 transition-all group">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-500 via-pink-500 to-amber-400 text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Copilot AI</p>
                                    <p class="text-[11px] text-slate-400">AI Assistant</p>
                                </div>
                            </a>

                        </div>
                    </div>

                    <!-- Direct Launch Office Portal Action -->
                    <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Access your Microsoft account to download Office desktop apps:
                        </p>
                        <a href="https://portal.office.com" target="_blank" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition-all shadow-md">
                            <span>Launch Office.com Portal</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @else
                <!-- No Active Subscription Hero Callout -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 p-8 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-3xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-2xl mx-auto shadow-inner mb-4">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Get Genuine Microsoft 365 License</h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 max-w-md mx-auto">
                        Unlock Word, Excel, PowerPoint, Outlook, and 1,000 GB OneDrive cloud storage for your PC, Mac, iPad, and Smartphone.
                    </p>
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('user.plans') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-extrabold px-6 py-3 rounded-2xl text-xs sm:text-sm flex items-center gap-2 transition-all shadow-lg shadow-[#0067b8]/25 active:scale-95">
                            <i class="fa-solid fa-cart-shopping text-sm"></i>
                            <span>Browse Official Plans</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- 3.2 STEP-BY-STEP LICENSE SETUP GUIDE ACCORDION -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                            <i class="fa-solid fa-circle-question text-[#0067b8] dark:text-sky-400 mr-1.5"></i>
                            How to Activate & Install Office 365
                        </h3>
                        <p class="text-xs text-slate-400">4 easy steps to start using your Microsoft license</p>
                    </div>
                    <span class="text-[10px] font-bold uppercase bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-2.5 py-1 rounded-full">
                        Official Guide
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Step 1 -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-[#0067b8] text-white flex items-center justify-center font-black text-xs shrink-0 mt-0.5">
                            1
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 dark:text-white">License Email Verification</h4>
                            <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed text-[11px]">
                                Once your order is approved, check your Microsoft email inbox for the official CSP activation invitation.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-[#0067b8] text-white flex items-center justify-center font-black text-xs shrink-0 mt-0.5">
                            2
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 dark:text-white">Sign In to Microsoft Portal</h4>
                            <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed text-[11px]">
                                Visit <a href="https://portal.office.com" target="_blank" class="text-[#0067b8] dark:text-sky-400 font-bold underline">portal.office.com</a> and login with your registered account.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-[#0067b8] text-white flex items-center justify-center font-black text-xs shrink-0 mt-0.5">
                            3
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 dark:text-white">Download Office Apps</h4>
                            <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed text-[11px]">
                                Click "Install Office" at the top right corner to download the complete 64-bit installer for PC or Mac.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 mt-0.5">
                            4
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 dark:text-white">Enjoy 1TB OneDrive & AI</h4>
                            <p class="text-slate-500 dark:text-slate-400 mt-1 leading-relaxed text-[11px]">
                                Open Word or Excel, sign in once, and your PC will automatically unlock genuine activation and 1,000 GB cloud sync.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3.3 RECENT ORDERS & TRANSACTIONS (100% REAL DATABASE DATA) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs" id="transactions">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Recent License Orders & Invoices</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Real-time status of your license purchases and payment receipts.</p>
                    </div>
                    <a href="{{ route('user.orders') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1">
                        <span>View All Orders</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                <th class="pb-3">Order ID</th>
                                <th class="pb-3">Plan</th>
                                <th class="pb-3">Payment Method</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="py-3.5 font-mono font-bold text-slate-900 dark:text-white">
                                        #{{ $order->order_number }}
                                        <div class="text-[10px] text-slate-400 font-normal">{{ $order->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="py-3.5 font-semibold text-slate-900 dark:text-white">
                                        {{ $order->plan_name }}
                                    </td>
                                    <td class="py-3.5">
                                        <span class="inline-flex items-center gap-1.5 font-semibold text-slate-800 dark:text-slate-200">
                                            @if($order->paymentMethod && $order->paymentMethod->logo_url)
                                                <img src="{{ $order->paymentMethod->logo_url }}" alt="{{ $order->paymentMethod->name }}" class="w-3.5 h-3.5 object-contain">
                                            @else
                                                <i class="fa-solid fa-wallet text-slate-400 text-xs"></i>
                                            @endif
                                            <span>{{ strtoupper($order->paymentMethod->name ?? $order->payment_method_slug ?: 'Manual') }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 font-extrabold text-slate-900 dark:text-white">
                                        ৳{{ number_format($order->payable_amount, 2) }}
                                    </td>
                                    <td class="py-3.5">
                                        @if($order->payment_status === 'paid')
                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400 font-bold text-[10px] bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Paid
                                            </span>
                                        @elseif($order->payment_status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 text-amber-700 dark:text-amber-400 font-bold text-[10px] bg-amber-50 dark:bg-amber-950/60 px-2.5 py-0.5 rounded-full border border-amber-200 dark:border-amber-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Approval
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-rose-700 dark:text-rose-400 font-bold text-[10px] bg-rose-50 dark:bg-rose-950/60 px-2.5 py-0.5 rounded-full border border-rose-200 dark:border-rose-800">
                                                <span>{{ ucfirst($order->payment_status) }}</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-right">
                                        <a href="{{ route('user.invoice', $order->id) }}" target="_blank" class="text-[#0067b8] dark:text-sky-400 hover:underline font-bold text-xs inline-flex items-center gap-1">
                                            <i class="fa-solid fa-file-invoice text-xs"></i>
                                            <span>Invoice</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        <p class="font-bold text-slate-600 dark:text-slate-300">No Orders Found</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Explore our Microsoft 365 plans to get genuine licenses.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ============================================================= -->
        <!-- RIGHT COLUMN (1 Col): Profile, Tickets, Notifications & Help  -->
        <!-- ============================================================= -->
        <div class="space-y-6">

            <!-- 1. Profile Information Summary Box -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Profile Information</h3>
                    <span class="text-[10px] font-bold uppercase bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 border border-sky-100 dark:border-sky-800 px-2 py-0.5 rounded-md">
                        {{ strtoupper($user->role) }}
                    </span>
                </div>

                <div class="mt-4 space-y-3.5 text-xs">
                    <div>
                        <p class="text-slate-400 font-bold uppercase text-[10px]">Full Name</p>
                        <p class="text-slate-900 dark:text-white font-bold mt-0.5 text-sm">{{ $user->name }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 font-bold uppercase text-[10px]">Microsoft Account Email</p>
                        <p class="text-slate-900 dark:text-white font-medium mt-0.5 break-all">{{ $user->email }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 font-bold uppercase text-[10px]">Phone Number</p>
                        <p class="text-slate-900 dark:text-white font-medium mt-0.5">{{ $user->phone ?: 'Not provided' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 font-bold uppercase text-[10px]">Member Since</p>
                        <p class="text-slate-900 dark:text-white font-medium mt-0.5">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('user.profile') }}" class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-regular fa-pen-to-square text-xs"></i>
                            <span>Edit Profile Details</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Recent Support Tickets Box (Dynamic) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-[#0067b8] dark:text-sky-400 text-sm"></i>
                        <h4 class="text-sm font-extrabold text-slate-900 dark:text-white">Support Tickets</h4>
                    </div>
                    <a href="{{ route('user.tickets.create') }}" class="text-[11px] font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                        + New Ticket
                    </a>
                </div>

                <div class="mt-3.5 space-y-3">
                    @forelse($recentTickets as $ticket)
                        <a href="{{ route('user.tickets.show', $ticket->id) }}" class="block p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 dark:bg-slate-800/40 dark:hover:bg-slate-800/70 border border-slate-100 dark:border-slate-800 transition-all">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-mono text-[11px] font-bold text-[#0067b8] dark:text-sky-400">
                                    #{{ $ticket->ticket_number }}
                                </span>
                                <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded-full border {{ $ticket->status_badge }}">
                                    {{ str_replace('_', ' ', $ticket->status) }}
                                </span>
                            </div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white mt-1 line-clamp-1">
                                {{ $ticket->subject }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1">
                                {{ $ticket->created_at->diffForHumans() }} • {{ ucfirst($ticket->department) }}
                            </p>
                        </a>
                    @empty
                        <div class="text-center py-4 text-xs text-slate-400">
                            <p>No support tickets raised.</p>
                            <a href="{{ route('user.tickets.create') }}" class="text-[#0067b8] dark:text-sky-400 font-bold mt-1 inline-block">Need help? Open a Ticket &rarr;</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. Security & Password Box -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm shrink-0">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white">Account Security</h4>
                        <p class="text-[11px] text-slate-400">Protect your Microsoft account</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                    Keep your reseller club login credentials up to date.
                </p>
                <a href="{{ route('user.password') }}" class="mt-4 w-full border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-key text-xs text-amber-500"></i>
                    <span>Change Password</span>
                </a>
            </div>

            <!-- 4. Dedicated Dhaka Support Hotline -->
            <div class="bg-gradient-to-br from-emerald-900 via-slate-900 to-slate-900 text-white rounded-3xl p-6 shadow-md border border-emerald-900/60">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-white">Dhaka Helpdesk</h4>
                        <p class="text-[11px] text-emerald-300">24/7 Priority CSP Support</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 mt-3 leading-relaxed">
                    Need instant help activating Office apps, configuring 1TB OneDrive, or upgrading licenses?
                </p>
                <div class="mt-4 space-y-2">
                    <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello, I need assistance with Microsoft Office Club.')) }}" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Message on WhatsApp</span>
                    </a>
                    <a href="tel:{{ site_setting('contact_phone_raw', '+880' . site_setting('whatsapp_raw_number', '8801342325558')) }}" class="w-full bg-white/10 hover:bg-white/20 text-white font-semibold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-phone text-xs"></i>
                        <span>Call {{ site_setting('contact_phone', site_setting('whatsapp_number', '+880 1342-325558')) }}</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
