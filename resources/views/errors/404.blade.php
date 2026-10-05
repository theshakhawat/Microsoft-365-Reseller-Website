@extends('errors.layout')

@section('title', '404 - Page Not Found')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
    
    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-sky-500/10 via-blue-500/20 to-sky-400/10 dark:from-sky-500/20 dark:to-blue-600/20 border border-sky-200/60 dark:border-sky-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-compass-drafting text-4xl sm:text-5xl text-[#0067b8] dark:text-sky-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-[#0067b8] text-white text-xs font-black tracking-widest uppercase shadow-md">
            404 Error
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Page Not Found
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        The link you followed may be broken, or the page may have been moved or removed from <span class="font-bold text-slate-700 dark:text-slate-300">{{ site_setting('site_name', 'Microsoft Office Club') }}</span>.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-house text-xs"></i>
            <span>Back to Homepage</span>
        </a>

        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-gauge-high text-xs text-sky-400"></i>
                    <span>Admin Dashboard</span>
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-user text-xs text-sky-400"></i>
                    <span>User Portal</span>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                <span>Sign In</span>
            </a>
        @endauth

        <button onclick="window.history.back()" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800/60 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Go Back</span>
        </button>
    </div>

    <!-- Quick Help Links -->
    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
        <span class="font-semibold text-slate-500 dark:text-slate-400">Need help?</span>
        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I encountered a 404 error on page: ' . url()->current()) }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline font-bold flex items-center gap-1">
            <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
        </a>
        <span>•</span>
        <a href="tel:{{ site_setting('contact_phone_raw', '+88096490123756') }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
            <i class="fa-solid fa-phone text-[10px]"></i> {{ site_setting('contact_phone', '09649-0123756') }}
        </a>
    </div>

</div>
@endsection
