@extends('errors.layout')

@section('title', '429 - Too Many Requests')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
    
    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-cyan-500/10 via-blue-500/20 to-cyan-400/10 dark:from-cyan-500/20 dark:to-blue-600/20 border border-cyan-200/60 dark:border-cyan-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-gauge-simple-high text-4xl sm:text-5xl text-cyan-500 dark:text-cyan-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-cyan-600 text-white text-xs font-black tracking-widest uppercase shadow-md">
            429 Rate Limit
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Too Many Requests
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        You've sent too many requests in a short period of time. Please wait a few seconds before trying again to protect platform stability.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
            <i class="fa-solid fa-arrows-rotate text-xs"></i>
            <span>Retry in a Moment</span>
        </button>

        <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-house text-xs text-[#0067b8] dark:text-sky-400"></i>
            <span>Home</span>
        </a>
    </div>

</div>
@endsection
