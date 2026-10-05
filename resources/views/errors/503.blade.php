@extends('errors.layout')

@section('title', '503 - Service Maintenance')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">
    
    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-amber-500/10 via-sky-500/20 to-amber-400/10 dark:from-amber-500/20 dark:to-sky-600/20 border border-amber-200/60 dark:border-amber-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-wrench text-4xl sm:text-5xl text-amber-500 dark:text-amber-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-amber-500 text-slate-950 text-xs font-black tracking-widest uppercase shadow-md">
            503 Maintenance
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Scheduled System Maintenance
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        We are currently upgrading our cloud provisioning services to serve you better. We'll be back online in just a few minutes.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
            <i class="fa-solid fa-arrows-rotate text-xs"></i>
            <span>Check Status & Refresh</span>
        </button>

        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I am inquiring about the maintenance status of Microsoft Office Club.') }}" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2">
            <i class="fa-brands fa-whatsapp text-sm"></i>
            <span>WhatsApp Support</span>
        </a>
    </div>

</div>
@endsection
