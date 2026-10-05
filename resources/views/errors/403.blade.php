@extends('errors.layout')

@section('title', '403 - Access Forbidden')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
    
    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-rose-500/10 via-amber-500/20 to-rose-400/10 dark:from-rose-500/20 dark:to-amber-600/20 border border-rose-200/60 dark:border-rose-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-shield-halved text-4xl sm:text-5xl text-rose-500 dark:text-rose-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-rose-500 text-white text-xs font-black tracking-widest uppercase shadow-md">
            403 Forbidden
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Access Restricted
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        You don't have permission to access this secure area or administrative resource. Please ensure you are signed in with the authorized account.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-gauge-high text-xs"></i>
                    <span>Admin Dashboard</span>
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-user text-xs"></i>
                    <span>My Customer Portal</span>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                <span>Sign In to Your Account</span>
            </a>
        @endauth

        <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-house text-xs text-[#0067b8] dark:text-sky-400"></i>
            <span>Return Home</span>
        </a>

        <button onclick="window.history.back()" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800/60 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Go Back</span>
        </button>
    </div>

    <!-- Quick Help Links -->
    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
        <span class="font-semibold text-slate-500 dark:text-slate-400">Believe this is a mistake?</span>
        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I received a 403 Forbidden Access error.') }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline font-bold flex items-center gap-1">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp Helpdesk
        </a>
    </div>

</div>
@endsection
