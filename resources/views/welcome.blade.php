@extends('layouts.website.website')

@section('title', 'Microsoft 365 Reseller Bangladesh | Official Subscriptions, Copilot AI & Cloud Licensing')

@section('content')

<!-- ========================================== -->
<!-- 1. HERO SECTION (Microsoft Style + Reseller) -->
<!-- ========================================== -->
<section class="relative bg-gradient-to-b from-[#f8fafc] via-[#f1f5f9] to-[#e2e8f0]/40 pt-10 pb-16 lg:pt-16 lg:pb-24 overflow-hidden border-b border-slate-200/80">
    <!-- Subtle Microsoft ambient glows -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-sky-200/40 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-40 right-10 w-[400px] h-[400px] bg-indigo-200/30 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Header & Pill Selector -->
        <div class="text-center max-w-4xl mx-auto space-y-5" data-aos="fade-up">

            <!-- Microsoft Official Reseller Tag -->
            <div class="inline-flex items-center gap-2.5 bg-white border border-slate-200/90 shadow-sm px-4 py-1.5 rounded-full text-xs font-semibold text-slate-800">
                <div class="grid grid-cols-2 gap-0.5 w-3.5 h-3.5 shrink-0">
                    <div class="bg-[#f25022] rounded-[1px]"></div>
                    <div class="bg-[#7fba00] rounded-[1px]"></div>
                    <div class="bg-[#00a4ef] rounded-[1px]"></div>
                    <div class="bg-[#ffb900] rounded-[1px]"></div>
                </div>
                <span>Official Microsoft Cloud Partner & Reseller Bangladesh</span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>

            <!-- Main Headline (Inspired by PDF 1 & PDF 2) -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                Work smarter across <span class="text-brand-600">Microsoft 365</span><br class="hidden sm:inline" />
                with <span class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 via-indigo-600 to-sky-500 bg-clip-text text-transparent">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 inline-block -mt-1 text-purple-600 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L14.5 9.5L22 12L14.5 14.5L12 22L9.5 14.5L2 12L9.5 9.5L12 2Z" fill="url(#copilot-grad)" />
                        <defs>
                            <linearGradient id="copilot-grad" x1="2" y1="2" x2="22" y2="22" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#0078D4" />
                                <stop offset="0.5" stop-color="#7B3FE4" />
                                <stop offset="1" stop-color="#F25022" />
                            </linearGradient>
                        </defs>
                    </svg>
                    Copilot AI
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed font-normal">
                All the benefits of Microsoft 365 in one unified plan. Genuine cloud licensing, automated tenant onboarding, local BDT invoicing via bKash & Nagad, and 24/7 Service.
            </p>
        </div>

        <!-- 8 Product Elements Grid (Light Cards with Hover Effects) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4 mt-10 items-stretch" data-aos="fade-up" data-aos-delay="100">

            <!-- Word -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-blue-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/word.png') }}" alt="Microsoft Word" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#185abd] transition-colors">Word</h4>
            </div>

            <!-- Excel -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/excel.png') }}" alt="Microsoft Excel" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#107c41] transition-colors">Excel</h4>
            </div>

            <!-- PowerPoint -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-orange-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/powerpoint.png') }}" alt="Microsoft PowerPoint" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#d83b01] transition-colors">PowerPoint</h4>
            </div>

            <!-- Outlook -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-sky-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/outlook.png') }}" alt="Microsoft Outlook" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0078d4] transition-colors">Outlook</h4>
            </div>

            <!-- Teams -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-indigo-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/teams.png') }}" alt="Microsoft Teams" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#6264a7] transition-colors">Teams</h4>
            </div>

            <!-- OneDrive -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-sky-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/onedrive.png') }}" alt="Microsoft OneDrive" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0078d4] transition-colors">OneDrive 1TB</h4>
            </div>

            <!-- Copilot AI -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-purple-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/copilot.png') }}" alt="Microsoft Copilot AI" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-md">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-purple-600 transition-colors">Copilot AI</h4>
            </div>

            <!-- Defender -->
            <div class="group flex flex-col items-center justify-center text-center p-4 rounded-2xl bg-white/90 hover:bg-white border border-slate-200/90 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer">
                <div class="w-12 h-12 flex items-center justify-center mb-2">
                    <img src="{{ asset('assets/img/products/defender.png') }}" alt="Microsoft Defender" class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110 drop-shadow-sm">
                </div>
                <h4 class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">Defender</h4>
            </div>

        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 2. COPILOT POPULAR PROMPTS (From PDF 2)    -->
<!-- ========================================== -->
<section id="copilot-showcase" class="py-16 lg:py-24 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <span class="text-xs font-extrabold uppercase tracking-widest text-purple-600 bg-purple-100 px-3 py-1 rounded-full border border-purple-200">
                Microsoft Copilot AI Integration
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3 inline-flex items-center justify-center gap-2.5 flex-wrap">
                <span>Popular prompts to try with</span>
                <span class="inline-flex items-center gap-2">
                    <img src="{{ asset('assets/img/products/copilot.png') }}" alt="Microsoft Copilot" class="w-8 h-8 sm:w-9 sm:h-9 object-contain inline-block -mt-1 drop-shadow-sm">
                    <span>Copilot</span>
                </span>
            </h2>
            <p class="text-slate-600 mt-2 text-sm sm:text-base">
                Copilot combines the power of Large Language Models (LLMs) with your Microsoft 365 business data.
            </p>
        </div>

        <!-- 4-Column Interactive Prompt Cards (PDF 2 style) -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Prompt 1: Word -->
            <div onclick="handleTryPrompt('Word', 'Rewrite this project proposal to make it more professional, concise, and persuasive for an enterprise client.', 'https://word.new')" class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:border-brand-500 hover:shadow-md transition-all group cursor-pointer" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <div class="flex items-center gap-2.5 text-xs font-bold text-[#185abd] mb-3">
                        <img src="{{ asset('assets/img/products/word.png') }}" alt="Word with Copilot" class="w-6 h-6 object-contain transition-transform group-hover:scale-110">
                        <span>Word with Copilot</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2 group-hover:text-brand-600 transition-colors">
                        Improve my writing & draft proposals
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic bg-slate-50 p-2.5 rounded-lg border border-slate-100/80">
                        "Rewrite this project proposal to make it more professional, concise, and persuasive for an enterprise client."
                    </p>
                </div>
                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-brand-600 group-hover:text-brand-700">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-copy text-[11px]"></i>
                        <span>Try this in Word</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </div>
            </div>

            <!-- Prompt 2: Excel -->
            <div onclick="handleTryPrompt('Excel', 'Analyze Q3 sales breakdown by city, calculate profit margins, and create a visual trend chart with projections.', 'https://excel.new')" class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:border-emerald-500 hover:shadow-md transition-all group cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <div class="flex items-center gap-2.5 text-xs font-bold text-[#107c41] mb-3">
                        <img src="{{ asset('assets/img/products/excel.png') }}" alt="Excel with Copilot" class="w-6 h-6 object-contain transition-transform group-hover:scale-110">
                        <span>Excel with Copilot</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2 group-hover:text-emerald-600 transition-colors">
                        Analyze sales data & generate formulas
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic bg-slate-50 p-2.5 rounded-lg border border-slate-100/80">
                        "Analyze Q3 sales breakdown by city, calculate profit margins, and create a visual trend chart with projections."
                    </p>
                </div>
                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-emerald-600 group-hover:text-emerald-700">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-copy text-[11px]"></i>
                        <span>Try this in Excel</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </div>
            </div>

            <!-- Prompt 3: PowerPoint -->
            <div onclick="handleTryPrompt('PowerPoint', 'Create a 10-slide executive presentation based on our annual report document with speaker notes and visuals.', 'https://powerpoint.new')" class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:border-orange-500 hover:shadow-md transition-all group cursor-pointer" data-aos="fade-up" data-aos-delay="150">
                <div>
                    <div class="flex items-center gap-2.5 text-xs font-bold text-[#d83b01] mb-3">
                        <img src="{{ asset('assets/img/products/powerpoint.png') }}" alt="PowerPoint with Copilot" class="w-6 h-6 object-contain transition-transform group-hover:scale-110">
                        <span>PowerPoint with Copilot</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2 group-hover:text-orange-600 transition-colors">
                        Turn notes into presentation slides
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic bg-slate-50 p-2.5 rounded-lg border border-slate-100/80">
                        "Create a 10-slide executive presentation based on our annual report document with speaker notes and visuals."
                    </p>
                </div>
                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-orange-600 group-hover:text-orange-700">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-copy text-[11px]"></i>
                        <span>Try this in PowerPoint</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </div>
            </div>

            <!-- Prompt 4: Outlook -->
            <div onclick="handleTryPrompt('Outlook', 'Summarize this 15-message client email chain and draft a polite reply confirming the next delivery milestone.', 'https://outlook.live.com')" class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-sm hover:border-sky-500 hover:shadow-md transition-all group cursor-pointer" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="flex items-center gap-2.5 text-xs font-bold text-[#0078d4] mb-3">
                        <img src="{{ asset('assets/img/products/outlook.png') }}" alt="Outlook with Copilot" class="w-6 h-6 object-contain transition-transform group-hover:scale-110">
                        <span>Outlook with Copilot</span>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2 group-hover:text-sky-600 transition-colors">
                        Summarize long email threads
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed italic bg-slate-50 p-2.5 rounded-lg border border-slate-100/80">
                        "Summarize this 15-message client email chain and draft a polite reply confirming the next delivery milestone."
                    </p>
                </div>
                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-sky-600 group-hover:text-sky-700">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-copy text-[11px]"></i>
                        <span>Try this in Outlook</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ======================================================= -->
<!-- WHAT'S INCLUDED: POWERFUL APPS SECTION (Official MS UI) -->
<!-- ======================================================= -->
<section id="included-apps" class="py-16 lg:py-24 bg-[#fafbfc] border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Header & Filter Row -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12" data-aos="fade-up">
            <div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-500 block mb-1">
                    WHAT'S INCLUDED
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 tracking-tight leading-tight">
                    Powerful apps to simplify your<br class="hidden sm:inline"> life and work
                </h2>

                <!-- App Category Pill Switcher -->
                <div class="flex items-center gap-2 mt-6">
                    <button onclick="switchAppTab('productivity')" id="tab-btn-productivity" class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 text-white shadow-sm">
                        Productivity Apps
                    </button>
                    <button onclick="switchAppTab('security')" id="tab-btn-security" class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-white hover:bg-slate-100 text-slate-700 border border-slate-200">
                        Security & Storage Apps
                    </button>
                </div>
            </div>

            <!-- Explore All Apps Link -->
            <div class="hidden sm:flex items-center">
                <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-[#0067b8] hover:text-[#005da6] group">
                    <span class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] group-hover:bg-[#0067b8] transition-colors">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                    <span>Explore all apps</span>
                </a>
            </div>
        </div>

        <!-- 1. Productivity Apps Grid -->
        <div id="grid-productivity" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- App 1: Copilot -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/copilot.png') }}" class="w-full h-full object-contain" alt="Microsoft Copilot">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Copilot</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Empower yourself with Copilot
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Easily navigate everyday tasks with Copilot, your AI companion that provides answers to complex questions and simplifies dense information into clear insights.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://copilot.microsoft.com" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Get started</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 2: Word -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/word.png') }}" class="w-full h-full object-contain" alt="Microsoft Word">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Word</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Create your best work
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Turn your thoughts into a first draft in minutes with powerful AI writing tools and collaborate with others in real time.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://word.new" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 3: Excel -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="150">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/excel.png') }}" class="w-full h-full object-contain" alt="Microsoft Excel">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Excel</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Turn data into insights
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Simplify complex data into easy-to-read spreadsheets and use Copilot to effortlessly analyze trends and generate formulas.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://excel.new" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 4: PowerPoint -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/powerpoint.png') }}" class="w-full h-full object-contain" alt="Microsoft PowerPoint">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">PowerPoint</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Polish your presentations
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Create polished slides in minutes using AI-driven design and collaboration tools built directly into PowerPoint.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://powerpoint.new" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 5: Outlook -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="250">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/outlook.png') }}" class="w-full h-full object-contain" alt="Microsoft Outlook">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Outlook</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Your inbox, organized
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Stay on top of multiple accounts with email, calendars, and contacts in one place, backed by intelligent spam filtering.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://outlook.live.com" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 6: Teams -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="300">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/teams.png') }}" class="w-full h-full object-contain" alt="Microsoft Teams">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Microsoft Teams</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Connect with anyone
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Transform the way you work with next-generation AI capabilities and bring together chat, video meetings, and calling in one space.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://teams.microsoft.com" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 7: OneDrive -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="350">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/onedrive.png') }}" class="w-full h-full object-contain" alt="Microsoft OneDrive">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">OneDrive</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        1 TB Secure Cloud Backup
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Store, access, and protect your files and photos across all your devices with built-in ransomware detection and file recovery.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://onedrive.live.com" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- App 8: Defender -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 transition-all group" data-aos="fade-up" data-aos-delay="400">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/defender.png') }}" class="w-full h-full object-contain" alt="Microsoft Defender">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Defender</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5 leading-snug">
                        Cross-device protection
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Safeguard personal data and devices with real-time malware protection, security alerts, and identity theft monitoring.
                    </p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="#plans" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4 decoration-slate-300 hover:decoration-[#0067b8] transition-colors">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- 2. Security & Storage Apps Grid (Tab 2) -->
        <div id="grid-security" class="hidden grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Sec App 1: OneDrive -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-lg transition-all">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/onedrive.png') }}" class="w-full h-full object-contain" alt="OneDrive">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">OneDrive</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">1 TB Secure Cloud Storage</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Automatic photo backup, Personal Vault with two-factor authentication, and ransomware restore.</p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://onedrive.live.com" target="_blank" class="text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4">Learn more →</a>
                </div>
            </div>

            <!-- Sec App 2: Defender -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-lg transition-all">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/defender.png') }}" class="w-full h-full object-contain" alt="Defender">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Microsoft Defender</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">Unified Security Dashboard</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Real-time antivirus scanning, continuous identity monitoring, and protection for up to 5 devices per person.</p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="#plans" class="text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4">Learn more →</a>
                </div>
            </div>

            <!-- Sec App 3: Outlook Protection -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-lg transition-all">
                <div>
                    <div class="w-10 h-10 mb-4">
                        <img src="{{ asset('assets/img/products/outlook.png') }}" class="w-full h-full object-contain" alt="Outlook">
                    </div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Outlook Security</span>
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">50 GB Ad-Free Encrypted Mail</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Advanced phishing protection, attachment scanning, and custom mailbox encryption.</p>
                </div>
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <a href="https://outlook.live.com" target="_blank" class="text-xs font-bold text-slate-900 hover:text-[#0067b8] underline underline-offset-4">Learn more →</a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 3. PRICING & PLANS (2 Annual Plans)        -->
<!-- ========================================== -->
<section id="plans" class="py-16 lg:py-24 bg-white relative border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-sky-50 px-3.5 py-1 rounded-full border border-sky-100">
                Official Microsoft Pricing & Licensing
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">
                Choose the plan that's right for you
            </h2>
            <p class="text-slate-600 mt-2 text-sm sm:text-base">
                Transparent Annual Subscription in Bangladesh. Instant license activation via bKash, Nagad & Cards.
            </p>
        </div>

        <!-- 2 Annual Plan Cards Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto items-stretch">

            <!-- Plan 1: Microsoft 365 Basic -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-9 flex flex-col justify-between shadow-sm hover:shadow-md hover:border-slate-300 transition-all relative" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">Microsoft 365 Basic</h3>

                    <!-- Price -->
                    <div class="mt-4 mb-1">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900">৳2,490</span>
                        <span class="text-xs font-semibold text-slate-500">/year</span>
                        <span class="text-xs text-slate-400 font-normal ml-1">($19.99/yr)</span>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Subscription automatically renews unless canceled in Microsoft account. <a href="#faq" class="underline text-brand-600">See terms</a>.
                    </p>

                    <!-- Action Button -->
                    <div class="mb-8">
                        <a href="https://wa.me/8801342325558?text=Hello%20I%20want%20to%20buy%20Microsoft%20365%20Basic%20Annual%20Plan" target="_blank" class="w-full bg-[#0f172a] hover:bg-[#0067b8] text-white font-bold px-7 py-3.5 rounded-xl text-sm transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2 group">
                            <span>Buy now</span>
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="h-px bg-slate-200/80 mb-6"></div>

                    <!-- Features List -->
                    <div class="space-y-3.5 text-xs text-slate-700">
                        <p class="font-bold text-slate-900 text-sm">Microsoft 365 Basic includes:</p>

                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span>For 1 person</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span>Works on web, iOS, and Android</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>100 GB</strong> of secure cloud storage</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span>OneDrive ransomware protection for your photos and files</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span>Outlook ad-free secure email</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-slate-800 text-xs mt-0.5 shrink-0"></i>
                            <span>Ongoing support for help when you need it</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Included App Logos Strip -->
                <div class="mt-8 pt-5 border-t border-slate-100 flex items-center gap-2">
                    <img src="{{ asset('assets/img/products/onedrive.png') }}" class="w-6 h-6 object-contain" alt="OneDrive" title="OneDrive 100GB">
                    <img src="{{ asset('assets/img/products/outlook.png') }}" class="w-6 h-6 object-contain" alt="Outlook" title="Outlook Secure Email">
                </div>
            </div>

            <!-- Plan 2: Microsoft 365 Personal (Full Featured) -->
            <div class="bg-white rounded-3xl border-2 border-[#0067b8] p-8 sm:p-9 pt-10 flex flex-col justify-between shadow-xl hover:shadow-2xl transition-all relative mt-4 md:mt-0" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute -top-3.5 left-8 bg-[#0067b8] text-white text-[11px] font-bold uppercase px-4 py-1 rounded-full tracking-wider shadow-md z-20 flex items-center gap-1.5 border border-white/40">
                    <i class="fa-solid fa-fire text-amber-300 text-xs"></i>
                    <span>Most Popular</span>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-slate-900">Microsoft 365 Personal</h3>

                    <!-- Price -->
                    <div class="mt-4 mb-1">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900">৳6,500</span>
                        <span class="text-xs font-semibold text-slate-500">/year</span>
                        <span class="text-xs text-slate-400 font-normal ml-1">($99.99/yr)</span>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Subscription automatically renews unless canceled in Microsoft account. <a href="#faq" class="underline text-brand-600">See terms</a>.
                    </p>

                    <!-- Action Button -->
                    <div class="mb-8">
                        <a href="https://wa.me/8801342325558?text=Hello%20I%20want%20to%20buy%20Microsoft%20365%20Personal%20Annual%20Plan" target="_blank" class="w-full bg-[#0067b8] hover:bg-[#005da6] text-white font-bold px-7 py-3.5 rounded-xl text-sm transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                            <span>Buy now</span>
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="h-px bg-slate-200/80 mb-6"></div>

                    <!-- Features List -->
                    <div class="space-y-3.5 text-xs text-slate-700">
                        <p class="font-bold text-slate-900 text-sm">Everything in Basic, plus:</p>

                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span>Use on up to <strong>5 devices simultaneously</strong></span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span>Works on PC, Mac, iPhone, iPad, and Android phones and tablets</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>1 TB (1000 GB)</strong> of secure cloud storage</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Word, Excel, PowerPoint, Outlook, and OneNote</strong> desktop apps with Microsoft Copilot</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span>Higher usage limits than free for select Copilot features</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span>Use Copilot in select apps with work files in a secure way</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span>Higher usage for AI image creation in Copilot</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Microsoft Defender</strong> advanced security for your identity & devices</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                            <span><strong>Microsoft Teams with Copilot</strong> to call, chat, and collaborate</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Included App Logos Strip -->
                <div class="mt-8 pt-5 border-t border-slate-100 flex flex-wrap items-center gap-2">
                    <img src="{{ asset('assets/img/products/copilot.png') }}" class="w-6 h-6 object-contain" alt="Copilot" title="Copilot AI">
                    <img src="{{ asset('assets/img/products/word.png') }}" class="w-6 h-6 object-contain" alt="Word" title="Word">
                    <img src="{{ asset('assets/img/products/excel.png') }}" class="w-6 h-6 object-contain" alt="Excel" title="Excel">
                    <img src="{{ asset('assets/img/products/powerpoint.png') }}" class="w-6 h-6 object-contain" alt="PowerPoint" title="PowerPoint">
                    <img src="{{ asset('assets/img/products/outlook.png') }}" class="w-6 h-6 object-contain" alt="Outlook" title="Outlook">
                    <img src="{{ asset('assets/img/products/teams.png') }}" class="w-6 h-6 object-contain" alt="Teams" title="Teams">
                    <img src="{{ asset('assets/img/products/onedrive.png') }}" class="w-6 h-6 object-contain" alt="OneDrive" title="OneDrive 1TB">
                    <img src="{{ asset('assets/img/products/defender.png') }}" class="w-6 h-6 object-contain" alt="Defender" title="Defender Security">
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ======================================================= -->
<!-- AI FEATURES SECTION: SLIDER / CAROUSEL (Cream Background) -->
<!-- ======================================================= -->
<section id="ai-features" class="py-16 lg:py-24 bg-[#f8f6f2] border-t border-[#ede7df] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header and Navigation Controls -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10" data-aos="fade-up">
            <div class="max-w-2xl">
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-500 block mb-1">
                    INTELLIGENT CAPABILITIES
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Smart AI capabilities in Microsoft 365 to accelerate your work, research, and ideas
                </h2>
            </div>

            <!-- Carousel Controls -->
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="scrollAiSlider('left')" aria-label="Previous" class="w-10 h-10 rounded-full border border-slate-300 bg-white hover:bg-slate-100 text-slate-800 flex items-center justify-center transition-all shadow-xs active:scale-95">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <button onclick="scrollAiSlider('right')" aria-label="Next" class="w-10 h-10 rounded-full border border-slate-300 bg-white hover:bg-slate-100 text-slate-800 flex items-center justify-center transition-all shadow-xs active:scale-95">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Horizontal Scrollable Feature Cards -->
        <div id="ai-slider-container" class="flex gap-6 overflow-x-auto pb-6 scroll-smooth snap-x snap-mandatory no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">

            <!-- Card 1: Researcher -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/Researcher.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="Researcher">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deep Research</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            Researcher
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Save time and streamline complex research with Researcher in Microsoft Copilot, delivering detailed, source-cited AI-powered reports from the web.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 2: Analyst -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/Analyst.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="Analyst">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Analytics</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            Analyst
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Make sense of your data quickly with Analyst in Microsoft Copilot, delivering comprehensive analysis and visual data storytelling from your documents with ease.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 3: OneDrive AI Restyle -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/OneDrive AI Restyle.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="OneDrive AI Restyle">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Creative Media</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            OneDrive AI Restyle
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Refresh your photos with OneDrive AI Restyle, using AI-powered tools to easily transform images with new looks and creative visual styles.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 4: Edit with Copilot -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/Edit with Copilot.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="Edit with Copilot">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Content Editing</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            Edit with Copilot
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Rewrite and refine your work right where you're editing — polish documents in Word, update tables in Excel, clean up structure in PowerPoint, and adjust tone in Outlook.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 5: Audio Overviews -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/Audio Overviews.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="Audio Overviews">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Audio AI</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            Audio Overviews
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Turn your notes into engaging audio with AI-powered overviews in Microsoft Copilot Notebooks, so you can listen and connect with your content in a whole new way.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 6: AI Rewrite in Teams -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/AI Rewrite in Teams.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="AI Rewrite in Teams">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Collaboration</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            AI Rewrite in Teams
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Communicate more clearly with Copilot in Microsoft Teams, helping you easily rewrite and refine messages for the right professional tone, length, and clarity.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

            <!-- Card 7: More AI Usage -->
            <div class="w-[300px] sm:w-[340px] shrink-0 bg-white rounded-3xl border border-slate-200/90 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                <div>
                    <!-- Visual Header Image -->
                    <div class="h-48 bg-[#f5f5f7] p-3 flex items-center justify-center overflow-hidden border-b border-slate-100">
                        <img src="{{ asset('assets/img/ai-features/More AI usage.png') }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="More AI usage">
                    </div>
                    <!-- Body Content -->
                    <div class="p-6">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Expanded Power</span>
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0067b8] transition-colors">
                            More AI Usage & Creation
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Microsoft 365 Personal and Family plans include higher limits in the Copilot app for image creation, chat, and select advanced features like Voice and Vision.
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 hover:text-[#0067b8] group/link">
                        <span class="w-6 h-6 rounded-full bg-slate-900 group-hover/link:bg-[#0067b8] text-white flex items-center justify-center text-[10px] transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                        <span>See Copilot plans</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ======================================================= -->
<!-- EXPLORE EVEN MORE BENEFITS SECTION (6-Card Grid)        -->
<!-- ======================================================= -->
<section id="more-benefits" class="py-16 lg:py-24 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Title -->
        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Explore even more benefits of Microsoft 365
            </h2>
            <p class="text-slate-600 mt-2 text-sm sm:text-base">
                Everything you need to create, collaborate, communicate, and stay secure across all your devices.
            </p>
        </div>

        <!-- 6 Benefit Cards Grid (2 rows x 3 columns) -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7 max-w-6xl mx-auto">

            <!-- Card 1: Copilot Apps -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/copilot.png') }}" class="w-full h-full object-contain" alt="Microsoft Copilot">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        Powerful productivity apps with AI
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Streamline your day with desktop versions of apps like Word, Excel, PowerPoint, Outlook, and OneNote integrated with Microsoft Copilot.
                    </p>
                </div>
            </div>

            <!-- Card 2: Defender Security -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/defender.png') }}" class="w-full h-full object-contain" alt="Microsoft Defender">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        Simplify your online security
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Keep you and your family safer online with continuous monitoring for threats, real-time alerts, tips, and expert guidance from Microsoft Defender.
                    </p>
                </div>
            </div>

            <!-- Card 3: OneDrive Storage -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="150">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/onedrive.png') }}" class="w-full h-full object-contain" alt="OneDrive 1TB Cloud">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        Trusted storage for priceless memories
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Quickly save, share, and edit your photos and files with 1 TB (1000 GB) OneDrive secure cloud and Microsoft 365 ransomware protection.
                    </p>
                </div>
            </div>

            <!-- Card 4: Outlook Communication -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/outlook.png') }}" class="w-full h-full object-contain" alt="Microsoft Outlook">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        Make the most of your day
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        With Outlook as command central, you can spend less time organizing your life and more time enjoying it with ad-free unified inbox & calendar.
                    </p>
                </div>
            </div>

            <!-- Card 5: Word & Notes Capture -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="250">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/word.png') }}" class="w-full h-full object-contain" alt="Microsoft Word & Notes">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        All your ideas in one place
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Capture inspiration in text, audio, photos, and sketches to create your next big project and access them across all your synced devices.
                    </p>
                </div>
            </div>

            <!-- Card 6: Teams Video Calling -->
            <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                <div>
                    <div class="w-12 h-12 mb-5">
                        <img src="{{ asset('assets/img/products/teams.png') }}" class="w-full h-full object-contain" alt="Microsoft Teams">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2.5">
                        All-day HD video calling & chat
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Join group calls and talk for up to 30 hours with up to 300 people with Microsoft Teams, built-in screen sharing, and noise suppression.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>



<!-- ========================================== -->
<!-- 5. HOW IT WORKS: 4 STEPS (Cream White Theme) -->
<!-- ========================================== -->
<section id="how-it-works" class="py-16 lg:py-24 bg-[#fcfaf7] text-slate-900 border-t border-b border-[#ece6de]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <span class="text-xs font-extrabold uppercase tracking-widest text-[#0067b8] bg-sky-50 border border-sky-200/80 px-3.5 py-1 rounded-full">
                Seamless 4-Step Activation
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-3">
                How It Works
            </h2>
            <p class="text-slate-600 mt-2 text-xs sm:text-sm">
                Get instant access to your Microsoft 365 license, 1TB cloud, and Copilot AI in four simple steps.
            </p>
        </div>

        <!-- 4 Step Cards Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Step 01 -->
            <div class="bg-white rounded-2xl p-6 border border-[#e8e2d8] shadow-sm hover:shadow-md hover:border-[#0067b8] transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0067b8] text-xl mb-5 shadow-xs">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base mb-1.5">Choose Plan</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Select the Microsoft 365 plan designed for your individual use, family, or enterprise business.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 text-[11px] text-emerald-600 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Instant Selection
                </div>
            </div>

            <!-- Step 02 -->
            <div class="bg-white rounded-2xl p-6 border border-[#e8e2d8] shadow-sm hover:shadow-md hover:border-[#0067b8] transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 text-xl mb-5 shadow-xs">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base mb-1.5">Secure Payment</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Complete your payment safely in seconds using bKash, Nagad, Rocket, or Bangladeshi bank cards.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 text-[11px] text-emerald-600 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Instant BDT Verification
                </div>
            </div>

            <!-- Step 03 -->
            <div class="bg-white rounded-2xl p-6 border border-[#e8e2d8] shadow-sm hover:shadow-md hover:border-[#0067b8] transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="150">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 text-xl mb-5 shadow-xs">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base mb-1.5">Get Access Link</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Receive your official Microsoft invitation link or tenant login directly via email & WhatsApp.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 text-[11px] text-amber-600 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-hourglass-half text-amber-500"></i> Wait for process your order
                </div>
            </div>

            <!-- Step 04 -->
            <div class="bg-white rounded-2xl p-6 border border-[#e8e2d8] shadow-sm hover:shadow-md hover:border-[#0067b8] transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 text-xl mb-5 shadow-xs">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base mb-1.5">Enjoy All Benefits</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Install full desktop Office apps, activate 1TB OneDrive storage, and leverage Copilot AI on all devices.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 text-[11px] text-emerald-600 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> 100% Unlocked
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 8. GET APPS / MULTI-DEVICE (Official MS Style) -->
<!-- ========================================== -->
<section class="py-14 lg:py-18 bg-[#faf8f5] border-t border-[#ede7df]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Download Microsoft 365
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">
                Available across all your devices — PC, Mac, iPhone, iPad, and Android.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto items-stretch">

            <!-- Desktop Download Card -->
            <div class="bg-white rounded-2xl border border-[#e8e2d8] p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-[#0067b8] transition-all" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <h4 class="font-bold text-slate-900 text-lg mb-1">
                        Download for PC & Mac
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-6">
                        Get the full desktop apps for your computer including Word, Excel, PowerPoint, and Outlook.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="https://www.microsoft.com/microsoft-365/download-office" target="_blank" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs font-bold px-5 py-3 rounded-xl flex items-center justify-center gap-2.5 transition-colors shadow-xs">
                        <i class="fa-solid fa-download text-sm"></i>
                        <span>Download for PC / Mac</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Download Card -->
            <div class="bg-white rounded-2xl border border-[#e8e2d8] p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-[#0067b8] transition-all" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h4 class="font-bold text-slate-900 text-lg mb-1">
                        Download for Mobile
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-6">
                        Stay productive on the go. Install the Microsoft 365 app directly from your mobile store.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="https://apps.apple.com/app/microsoft-365-office/id541164041" target="_blank" class="inline-flex transition-transform hover:scale-105">
                        <img src="{{ asset('assets/img/app-store.png') }}" class="h-10 w-auto object-contain rounded-lg" alt="Download on the App Store">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.microsoft.office.officehubrow" target="_blank" class="inline-flex transition-transform hover:scale-105">
                        <img src="{{ asset('assets/img/play-store.png') }}" class="h-12 scale-1.2 w-auto object-contain rounded-lg" alt="Get it on Google Play">
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 9. DID YOU KNOW? FAQ (From PDF 2 & PDF 3)  -->
<!-- ========================================== -->
<section id="faq" class="py-16 lg:py-24 bg-white border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Did you know?</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Frequently asked questions about Microsoft 365 subscriptions in Bangladesh.</p>
            </div>
            <button onclick="toggleAllFaqs()" id="btn-toggle-all-faq" class="text-xs font-bold text-brand-600 bg-sky-50 border border-sky-100 px-3.5 py-1.5 rounded-lg hover:bg-sky-100 transition-colors">
                Expand all
            </button>
        </div>

        <!-- Numbered Accordion (Microsoft 365 + Copilot Official FAQ) -->
        <div class="space-y-6">

            <!-- 01/ (Open by Default) -->
            <div class="border-b border-slate-200 pb-6">
                <button onclick="toggleFaq(1)" class="w-full text-left font-bold text-slate-900 flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] transition-colors group">
                    <div class="flex items-start gap-4">
                        <span class="text-xs font-mono font-bold text-slate-400 pt-0.5">01/</span>
                        <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0067b8] transition-colors">
                            Microsoft 365 brings your favorite apps together with Copilot
                        </span>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                        <span id="faq-sign-1" class="font-bold">−</span>
                    </div>
                </button>
                <div id="faq-answer-1" class="pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Microsoft 365 includes familiar apps like Word, Excel, PowerPoint, Outlook, Teams, and OneDrive, plus Copilot experiences that help you create, find, summarize, and get things done across your work. With a Microsoft account, you can use <a href="https://word.new" target="_blank" class="text-[#0067b8] underline font-semibold">Word</a>, <a href="https://excel.new" target="_blank" class="text-[#0067b8] underline font-semibold">Excel</a>, and <a href="https://powerpoint.new" target="_blank" class="text-[#0067b8] underline font-semibold">PowerPoint</a> in your browser for free. For desktop apps, more storage, and additional premium features, you can explore Microsoft 365 plans.
                </div>
            </div>

            <!-- 02/ (Collapsed by default) -->
            <div class="border-b border-slate-200 pb-6">
                <button onclick="toggleFaq(2)" class="w-full text-left font-bold text-slate-900 flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] transition-colors group">
                    <div class="flex items-start gap-4">
                        <span class="text-xs font-mono font-bold text-slate-400 pt-0.5">02/</span>
                        <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0067b8] transition-colors">
                            Copilot helps you quickly get oriented and move work forward
                        </span>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                        <span id="faq-sign-2" class="font-bold">+</span>
                    </div>
                </button>
                <div id="faq-answer-2" class="hidden pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Microsoft 365 Copilot Chat brings together work context through natural conversation, helping you understand priorities, catch up on progress, clarify intent, explore options, and identify next steps without breaking your flow.
                </div>
            </div>

            <!-- 03/ (Collapsed by default) -->
            <div class="border-b border-slate-200 pb-6">
                <button onclick="toggleFaq(3)" class="w-full text-left font-bold text-slate-900 flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] transition-colors group">
                    <div class="flex items-start gap-4">
                        <span class="text-xs font-mono font-bold text-slate-400 pt-0.5">03/</span>
                        <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0067b8] transition-colors">
                            Microsoft Copilot keeps work and personal experiences separate
                        </span>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                        <span id="faq-sign-3" class="font-bold">+</span>
                    </div>
                </button>
                <div id="faq-answer-3" class="hidden pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Microsoft Copilot brings personal and work experiences into one simpler place while keeping them separate. Work stays work, and personal stays personal, so your work data, chats, files, and organizational protections remain separate from your personal Copilot experience.
                </div>
            </div>

            <!-- 04/ (Collapsed by default) -->
            <div class="border-b border-slate-200 pb-6">
                <button onclick="toggleFaq(4)" class="w-full text-left font-bold text-slate-900 flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] transition-colors group">
                    <div class="flex items-start gap-4">
                        <span class="text-xs font-mono font-bold text-slate-400 pt-0.5">04/</span>
                        <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0067b8] transition-colors">
                            Copilot works with Microsoft 365 security protections
                        </span>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                        <span id="faq-sign-4" class="font-bold">+</span>
                    </div>
                </button>
                <div id="faq-answer-4" class="hidden pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Copilot is built with security, privacy, and compliance in mind. It respects existing permissions and enterprise protections, helping safeguard your content, accounts, and collaboration while you work.
                </div>
            </div>

            <!-- 05/ (Collapsed by default) -->
            <div class="border-b border-slate-200 pb-6">
                <button onclick="toggleFaq(5)" class="w-full text-left font-bold text-slate-900 flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] transition-colors group">
                    <div class="flex items-start gap-4">
                        <span class="text-xs font-mono font-bold text-slate-400 pt-0.5">05/</span>
                        <span class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-[#0067b8] transition-colors">
                            You're in control of when you use AI
                        </span>
                    </div>
                    <div class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center text-xs shadow-xs shrink-0">
                        <span id="faq-sign-5" class="font-bold">+</span>
                    </div>
                </button>
                <div id="faq-answer-5" class="hidden pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Copilot responds when you choose to use it. You stay in control of when and how you use AI features, and your existing privacy and security settings continue to apply.
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 10. CONTACT & SUPPORT HUB (Cream White Theme) -->
<!-- ========================================== -->
<section id="contact-support" class="py-16 lg:py-24 bg-[#faf8f5] text-slate-900 border-t border-[#ede7df]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            <!-- Left Bio & Hotlines -->
            <div class="lg:col-span-6 space-y-6" data-aos="fade-up">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-[#0067b8] bg-sky-50 px-3.5 py-1 rounded-full border border-sky-200">
                    <i class="fa-solid fa-building-shield text-xs"></i> About Microsoft 365 Reseller BD
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Empowering individuals & teams with frictionless Microsoft 365 access.
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Built to eliminate high international credit card currency exchange fees, complex foreign invoicing, and scattered renewals. Get genuine Microsoft subscriptions delivered directly to your personal or company account with trusted local bKash, Nagad, and banking channels.
                </p>

                <div class="space-y-3 text-xs sm:text-sm text-slate-700 font-medium">
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                        <span>Direct integration with bKash, Nagad & Bangladeshi Banking Rails</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                        <span>Zero duplicate active packages — automated validity stacking</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                        <span>Comprehensive audit trail & downloadable local VAT Tax Invoices</span>
                    </p>
                </div>

                <!-- Direct Contact Cards -->
                <div class="grid sm:grid-cols-2 gap-4 pt-3">
                    <a href="tel:096490123756" class="p-4 bg-white rounded-2xl border border-[#e8e2d8] shadow-xs hover:shadow-md hover:border-[#0067b8] transition-all flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0067b8] text-lg shrink-0 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Customer Support</p>
                            <p class="text-sm font-extrabold text-slate-900">096490123756</p>
                        </div>
                    </a>

                    <a href="https://wa.me/8801342325558" target="_blank" class="p-4 bg-white rounded-2xl border border-[#e8e2d8] shadow-xs hover:shadow-md hover:border-emerald-500 transition-all flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 text-lg shrink-0 group-hover:scale-105 transition-transform">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">WhatsApp Support</p>
                            <p class="text-sm font-extrabold text-emerald-600">+880 1342-325558</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Right Contact Form Card -->
            <div class="lg:col-span-6 bg-white rounded-3xl p-7 sm:p-9 border border-[#e8e2d8] shadow-lg" data-aos="fade-up">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#0067b8] bg-sky-50 px-3 py-1 rounded-full border border-sky-100 inline-block mb-3">
                    Contact Us
                </span>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-1.5">Get In Touch</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6">Have questions regarding packages, renewals, or enterprise licenses? Send us a note.</p>

                <form onsubmit="handleContactSubmit(event)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Your Name</label>
                        <input type="text" id="contact-name" placeholder="e.g. Tanvir Hasan" required class="w-full bg-[#fbf9f6] border border-slate-300/80 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#0067b8] focus:bg-white transition-all">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                            <input type="email" id="contact-email" placeholder="name@domain.com" required class="w-full bg-[#fbf9f6] border border-slate-300/80 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#0067b8] focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone / WhatsApp Number</label>
                            <input type="text" id="contact-phone" placeholder="017XXXXXXXX" required class="w-full bg-[#fbf9f6] border border-slate-300/80 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#0067b8] focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Message / Requirement</label>
                        <textarea id="contact-message" rows="3" placeholder="How can our Microsoft team assist you today?" required class="w-full bg-[#fbf9f6] border border-slate-300/80 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#0067b8] focus:bg-white transition-all"></textarea>
                    </div>

                    <button type="submit" id="contact-submit-btn" class="w-full bg-[#0067b8] hover:bg-[#005da6] text-white font-bold py-3.5 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <i class="fa-regular fa-paper-plane text-xs"></i>
                        <span>Send Message</span>
                    </button>
                    <p id="contact-status" class="hidden text-center text-xs font-semibold text-emerald-600 pt-2"></p>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 11. BOTTOM CTA (Microsoft Enterprise Style) -->
<!-- ========================================== -->
<section class="py-16 lg:py-20 bg-[#0f172a] text-white text-center relative overflow-hidden border-t border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-3">
            Ready to upgrade your Microsoft 365 licensing?
        </h2>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl mx-auto mb-8 leading-relaxed">
            Get instant access to genuine Microsoft cloud subscriptions, 1TB OneDrive storage, and full Office desktop apps with local bKash, Nagad, and Bangladeshi bank checkout.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5">
            <a href="#plans" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005da6] text-white font-bold px-7 py-3.5 rounded-xl text-xs sm:text-sm transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <span>View Annual Plans</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
            <a href="https://wa.me/8801342325558?text=Hello%20I%20want%20to%20activate%20Microsoft%20365" target="_blank" class="w-full sm:w-auto bg-[#25d366] hover:bg-[#20bd5a] text-slate-950 font-bold px-7 py-3.5 rounded-xl text-xs sm:text-sm transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>WhatsApp: +880 1342-325558</span>
            </a>
            <a href="tel:096490123756" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 text-slate-100 font-bold px-6 py-3.5 rounded-xl text-xs sm:text-sm border border-slate-700 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-phone text-xs text-sky-400"></i>
                <span>096490123756</span>
            </a>
        </div>
    </div>
</section>

@endsection

@push('js')
<script>
    // Billing Switcher and Dynamic Pricing
    let currentBillingCycle = 'monthly';

    const pricingTable = {
        personal: {
            monthly: 650
            , annual: 6500
        }
        , family: {
            monthly: 990
            , annual: 9900
        }
        , standard: {
            monthly: 1450
            , annual: 14500
        }
        , premium: {
            monthly: 2550
            , annual: 25500
        }
    };

    function switchBilling(cycle) {
        currentBillingCycle = cycle;
        const btnMonthly = document.getElementById('btn-monthly');
        const btnAnnual = document.getElementById('btn-annual');

        if (cycle === 'monthly') {
            btnMonthly.className = "px-6 py-2.5 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-slate-900 shadow-sm";
            btnAnnual.className = "px-6 py-2.5 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-slate-900 flex items-center gap-1.5";
        } else {
            btnAnnual.className = "px-6 py-2.5 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-slate-900 shadow-sm flex items-center gap-1.5";
            btnMonthly.className = "px-6 py-2.5 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-slate-900";
        }

        updateAllPrices();
    }

    function updateAllPrices() {
        const isAnnual = currentBillingCycle === 'annual';
        const suffix = isAnnual ? '/ yr' : '/ mo';

        // Personal
        const pPersonal = pricingTable.personal[currentBillingCycle];
        document.getElementById('price-personal').innerText = `৳${pPersonal.toLocaleString()}`;
        document.getElementById('period-personal').innerText = suffix;

        // Family
        const pFamily = pricingTable.family[currentBillingCycle];
        document.getElementById('price-family').innerText = `৳${pFamily.toLocaleString()}`;
        document.getElementById('period-family').innerText = suffix;

        // Standard
        const pStd = pricingTable.standard[currentBillingCycle];
        document.getElementById('price-standard').innerText = `৳${pStd.toLocaleString()}`;
        document.getElementById('period-standard').innerText = suffix;
        calculatePrice('standard');

        // Premium
        const pPrem = pricingTable.premium[currentBillingCycle];
        document.getElementById('price-premium').innerText = `৳${pPrem.toLocaleString()}`;
        document.getElementById('period-premium').innerText = suffix;
        calculatePrice('premium');
    }

    function adjustQty(plan, delta) {
        const input = document.getElementById(`qty-${plan}`);
        if (!input) return;
        let val = parseInt(input.value) || 1;
        val = Math.max(1, val + delta);
        input.value = val;
        calculatePrice(plan);
    }

    function calculatePrice(plan) {
        const input = document.getElementById(`qty-${plan}`);
        const totalEl = document.getElementById(`total-${plan}`);
        if (!input || !totalEl) return;

        let qty = parseInt(input.value) || 1;
        if (qty < 1) {
            qty = 1;
            input.value = 1;
        }

        const unit = pricingTable[plan][currentBillingCycle];
        const total = unit * qty;
        const suffix = currentBillingCycle === 'annual' ? '/ yr' : '/ mo';
        totalEl.innerText = `Total: ৳${total.toLocaleString()} ${suffix}`;
    }

    // AI Search Prompt Setter
    function setSearchPrompt(text) {
        const input = document.getElementById('ai-search-input');
        if (input) {
            input.value = text;
            input.focus();
        }
    }

    // Hero Segment Switcher (Personal vs Business)
    function switchHeroSegment(segment) {
        const pillPers = document.getElementById('hero-pill-personal');
        const pillBiz = document.getElementById('hero-pill-business');
        if (segment === 'personal') {
            pillPers.className = "px-5 py-2 rounded-full bg-slate-900 text-white shadow-sm transition-all";
            pillBiz.className = "px-5 py-2 rounded-full text-slate-700 hover:text-slate-900 transition-all";
        } else {
            pillBiz.className = "px-5 py-2 rounded-full bg-slate-900 text-white shadow-sm transition-all";
            pillPers.className = "px-5 py-2 rounded-full text-slate-700 hover:text-slate-900 transition-all";
        }
    }

    // FAQ Accordion
    function toggleFaq(id) {
        const answer = document.getElementById(`faq-answer-${id}`);
        const sign = document.getElementById(`faq-sign-${id}`);
        if (!answer || !sign) return;

        const isHidden = answer.classList.contains('hidden');
        if (isHidden) {
            answer.classList.remove('hidden');
            sign.innerText = '−';
        } else {
            answer.classList.add('hidden');
            sign.innerText = '+';
        }
    }

    let allFaqsExpanded = false;

    function toggleAllFaqs() {
        allFaqsExpanded = !allFaqsExpanded;
        const btn = document.getElementById('btn-toggle-all-faq');
        if (btn) btn.innerText = allFaqsExpanded ? 'Collapse all' : 'Expand all';

        for (let i = 1; i <= 5; i++) {
            const answer = document.getElementById(`faq-answer-${i}`);
            const sign = document.getElementById(`faq-sign-${i}`);
            if (answer && sign) {
                if (allFaqsExpanded) {
                    answer.classList.remove('hidden');
                    sign.innerText = '−';
                } else {
                    answer.classList.add('hidden');
                    sign.innerText = '+';
                }
            }
        }
    }

    // Contact Form Handler
    function handleContactSubmit(e) {
        e.preventDefault();
        const name = document.getElementById('contact-name').value;
        const email = document.getElementById('contact-email').value;
        const phone = document.getElementById('contact-phone').value;
        const msg = document.getElementById('contact-message').value;
        const status = document.getElementById('contact-status');

        const waText = encodeURIComponent(`Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nMessage: ${msg}`);
        window.open(`https://wa.me/8801342325558?text=${waText}`, '_blank');

        if (status) {
            status.classList.remove('hidden');
            status.innerText = 'Thank you! Redirecting to WhatsApp sales desk...';
        }
    }

    // Try Prompt with Copilot Handler (Copy to Clipboard & Launch App)
    function handleTryPrompt(appName, promptText, launchUrl) {
        // Copy to clipboard
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(promptText).catch(() => {});
        } else {
            const temp = document.createElement('textarea');
            temp.value = promptText;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
        }

        // Show toast
        showCopilotToast(`📋 Copied prompt to clipboard! Opening Microsoft ${appName}...`);

        // Launch Microsoft Web App in new tab
        setTimeout(() => {
            window.open(launchUrl, '_blank');
        }, 500);
    }

    function showCopilotToast(message) {
        let toast = document.getElementById('copilot-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'copilot-toast';
            toast.className = 'fixed bottom-10 right-6 z-50 max-w-md bg-slate-900 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-2xl border border-sky-500/40 flex items-center gap-3 transition-all duration-300 opacity-0 translate-y-[-10px] pointer-events-none';
            document.body.appendChild(toast);
        }

        toast.innerHTML = `
            <div class="w-7 h-7 rounded-lg bg-sky-950 flex items-center justify-center shrink-0">
                <img src="{{ asset('assets/img/products/copilot.png') }}" class="w-5 h-5 object-contain" alt="Copilot">
            </div>
            <span>${message}</span>
        `;

        toast.classList.remove('opacity-0', 'translate-y-[-10px]', 'pointer-events-none');
        toast.classList.add('opacity-100', 'translate-y-0');

        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-[-10px]', 'pointer-events-none');
        }, 3200);
    }

    // Switch App Tabs (Productivity vs Security & Storage)
    function switchAppTab(tab) {
        const prodGrid = document.getElementById('grid-productivity');
        const secGrid = document.getElementById('grid-security');
        const prodBtn = document.getElementById('tab-btn-productivity');
        const secBtn = document.getElementById('tab-btn-security');

        if (tab === 'productivity') {
            if (prodGrid) prodGrid.classList.remove('hidden');
            if (secGrid) secGrid.classList.add('hidden');
            if (prodBtn) {
                prodBtn.className = 'px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 text-white shadow-sm';
            }
            if (secBtn) {
                secBtn.className = 'px-4 py-2 rounded-full text-xs font-bold transition-all bg-white hover:bg-slate-100 text-slate-700 border border-slate-200';
            }
        } else {
            if (prodGrid) prodGrid.classList.add('hidden');
            if (secGrid) secGrid.classList.remove('hidden');
            if (prodBtn) {
                prodBtn.className = 'px-4 py-2 rounded-full text-xs font-bold transition-all bg-white hover:bg-slate-100 text-slate-700 border border-slate-200';
            }
            if (secBtn) {
                secBtn.className = 'px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 text-white shadow-sm';
            }
        }
    }

    // Scroll AI Features Slider
    function scrollAiSlider(direction) {
        const slider = document.getElementById('ai-slider-container');
        if (!slider) return;
        const scrollAmount = 360;
        if (direction === 'left') {
            slider.scrollBy({
                left: -scrollAmount
                , behavior: 'smooth'
            });
        } else {
            slider.scrollBy({
                left: scrollAmount
                , behavior: 'smooth'
            });
        }
    }

</script>
@endpush
