@extends('errors.layout')

@section('title', '419 - Page Expired')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
    
    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-amber-500/10 via-yellow-500/20 to-amber-400/10 dark:from-amber-500/20 dark:to-yellow-600/20 border border-amber-200/60 dark:border-amber-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-clock-rotate-left text-4xl sm:text-5xl text-amber-500 dark:text-amber-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-amber-500 text-slate-950 text-xs font-black tracking-widest uppercase shadow-md">
            419 Expired
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Session Expired
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        Your security token or form session has timed out due to inactivity. Simply refresh the page to renew your security session and try again.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
            <i class="fa-solid fa-arrows-rotate text-xs"></i>
            <span>Refresh & Try Again</span>
        </button>

        <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-right-to-bracket text-xs text-sky-400"></i>
            <span>Sign In Again</span>
        </a>

        <a href="{{ url('/') }}" class="w-full sm:w-auto px-5 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-house text-xs"></i>
            <span>Home</span>
        </a>
    </div>

    <!-- Quick Help Links -->
    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
        <span class="font-semibold text-slate-500 dark:text-slate-400">Stuck in a loop?</span>
        <a href="{{ route('login') }}" class="text-[#0067b8] dark:text-sky-400 hover:underline font-bold">
            Re-login to continue
        </a>
        <span>•</span>
        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I have a session timeout issue on Microsoft Office Club.') }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline font-bold flex items-center gap-1">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp Support
        </a>
    </div>

</div>
@endsection
