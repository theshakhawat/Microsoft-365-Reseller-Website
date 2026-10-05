@extends('errors.layout')

@section('title', '500 - Server Error')

@section('content')
<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 sm:p-12 text-center shadow-xl relative overflow-hidden">

    <!-- Top Visual Icon & Status Badge -->
    <div class="relative inline-flex items-center justify-center mb-6">
        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-gradient-to-tr from-purple-500/10 via-rose-500/20 to-purple-400/10 dark:from-purple-500/20 dark:to-rose-600/20 border border-purple-200/60 dark:border-purple-700/60 flex items-center justify-center shadow-inner animate-float">
            <i class="fa-solid fa-server text-4xl sm:text-5xl text-purple-600 dark:text-purple-400"></i>
        </div>
        <span class="absolute -bottom-2 px-3.5 py-1 rounded-full bg-purple-600 text-white text-xs font-black tracking-widest uppercase shadow-md">
            500 Error
        </span>
    </div>

    <!-- Title & Message -->
    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
        Internal Server Error
    </h1>
    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
        Something unexpected went wrong while processing your request. Our technical engineers have been automatically notified and are actively looking into it.
    </p>

    <!-- Interactive Navigation Buttons -->
    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005da6] text-white font-bold text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
            <i class="fa-solid fa-arrows-rotate text-xs"></i>
            <span>Reload Page</span>
        </button>

        <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-house text-xs text-sky-400"></i>
            <span>Return to Homepage</span>
        </a>

        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode('Hello, I experienced a 500 server error on Microsoft Office Club.') }}" target="_blank" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white font-bold text-xs sm:text-sm transition-all flex items-center justify-center gap-2">
            <i class="fa-brands fa-whatsapp text-sm"></i>
            <span>Contact Support</span>
        </a>
    </div>

    <!-- Quick Help Links -->
    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800/80 flex flex-wrap items-center justify-center gap-4 text-xs text-slate-400">
        <span class="font-semibold text-slate-500 dark:text-slate-400">Helpdesk:</span>
        <a href="tel:{{ site_setting('contact_phone_raw', '+88096490123756') }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors font-bold">
            <i class="fa-solid fa-phone text-[10px] text-[#0067b8]"></i> {{ site_setting('contact_phone', '09649-0123756') }}
        </a>
        <span>•</span>
        <a href="mailto:{{ site_setting('contact_email', 'support@cloudsync.com.bd') }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
            {{ site_setting('contact_email', 'support@cloudsync.com.bd') }}
        </a>
    </div>

</div>
@endsection
