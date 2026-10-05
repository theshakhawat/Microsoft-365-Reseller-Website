@extends('layouts.website.website')

@section('title', 'Microsoft 365 Reseller Bangladesh | Official Subscriptions, Copilot AI & Cloud Licensing')

@section('content')

<!-- ========================================== -->
<!-- 1. HERO SECTION (Microsoft 365 All-in-One) -->
<!-- ========================================== -->
<section class="relative bg-[#edf4fc] dark:bg-slate-950 pt-10 sm:pt-14 lg:pt-16 pb-12 sm:pb-16 lg:pb-20 overflow-hidden border-b border-slate-200/80 dark:border-slate-800">

    <!-- Background Image with smooth light/dark overlay -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ site_file_url('hero_bg_image', 'assets/img/bg.png') }}" alt="Background" class="w-full h-full object-cover object-center opacity-70 dark:opacity-20 transition-opacity duration-300">
        <div class="absolute inset-0 bg-gradient-to-b from-[#edf4fc]/70 via-[#f5f9fe]/40 to-[#edf4fc]/90 dark:from-slate-950/90 dark:via-slate-900/85 dark:to-slate-950"></div>
    </div>

    <!-- Ambient colorful background glows -->
    <div class="absolute -top-16 left-1/4 w-[500px] h-[500px] bg-sky-300/20 dark:bg-sky-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-10 right-10 w-[450px] h-[450px] bg-indigo-300/20 dark:bg-indigo-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute -bottom-10 right-1/3 w-[350px] h-[350px] bg-amber-200/20 dark:bg-amber-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="relative z-10 max-w-[1600px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">

        <!-- Top Banner Grid: Left Headline & CTAs (5 cols) + Right Visual Mockup (7 cols) -->
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">

            <!-- Left Column: Copy & Actions (5 cols) -->
            <div class="lg:col-span-5 space-y-5 text-left">

                <!-- Kicker / Category Tag -->
                <p class="text-xs sm:text-sm font-bold uppercase tracking-[0.2em] text-[#0067b8] dark:text-sky-400">
                    {{ site_setting('hero_badge_text', 'WORK SMARTER. TOGETHER.') }}
                </p>

                <!-- Main Headline -->
                @php
                    $heroTitle = site_setting('hero_title', 'The all-in-one productivity platform for a more connected world');
                    $heroHighlight = site_setting('hero_highlight_text', 'a more connected world');
                    if (!empty($heroHighlight) && str_contains($heroTitle, $heroHighlight)) {
                        $formattedHeroTitle = str_replace($heroHighlight, '<span class="text-[#0067b8] dark:text-sky-400">' . e($heroHighlight) . '</span>', e($heroTitle));
                    } else {
                        $formattedHeroTitle = e($heroTitle);
                    }
                @endphp
                <h1 class="text-3xl sm:text-4xl lg:text-[40px] xl:text-[46px] font-black text-slate-900 dark:text-white tracking-tight leading-[1.2] sm:leading-[1.18] lg:leading-[1.18]">
                    {!! $formattedHeroTitle !!}
                </h1>

                <!-- Subheading Description -->
                <p class="text-sm sm:text-[15px] lg:text-[15px] text-slate-600 dark:text-slate-300 leading-relaxed font-normal max-w-lg">
                    {{ site_setting('hero_description', 'Microsoft 365 brings together your favorite apps, AI-powered tools, cloud storage, and advanced security — all in one place, so you can create, collaborate, and get more done from anywhere.') }}
                </p>

                <!-- Action CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3.5 pt-2">
                    <a href="{{ site_setting('hero_btn1_url', '#plans') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 sm:px-7 py-3.5 rounded-xl text-sm sm:text-[15px] shadow-lg shadow-[#0067b8]/25 hover:shadow-xl transition-all flex items-center justify-center gap-2 group cursor-pointer active:scale-95">
                        <span>{{ site_setting('hero_btn1_text', 'Get Microsoft 365') }}</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                    </a>

                    <a href="{{ site_setting('hero_btn2_url', '#plans') }}" class="border border-[#0067b8] dark:border-sky-400 text-[#0067b8] dark:text-sky-300 hover:bg-[#0067b8]/5 dark:hover:bg-sky-950/40 bg-white/80 dark:bg-slate-900/60 font-bold px-6 sm:px-7 py-3.5 rounded-xl text-sm sm:text-[15px] transition-all flex items-center justify-center cursor-pointer active:scale-95 shadow-sm">
                        <span>{{ site_setting('hero_btn2_text', 'See plans and pricing') }}</span>
                    </a>
                </div>

            </div>

            <!-- Right Column: Visual Mockup Illustration (7 cols - Larger & Expanded) -->
            <div class="lg:col-span-7 relative flex items-center justify-center lg:justify-end">
                <div class="relative w-full group">
                    <img src="{{ site_file_url('hero_banner_image', 'assets/img/banner.png') }}" alt="{{ site_setting('hero_title', 'Microsoft 365 Productivity Platform & Copilot AI') }}" class="w-full h-auto object-contain max-h-[560px] lg:max-h-[640px] drop-shadow-2xl transition-transform duration-500 group-hover:scale-[1.02]">
                </div>
            </div>

        </div>

        @if(site_is_enabled('hero_apps_strip_enabled', true))
        <!-- ==================================================== -->
        <!-- Floating Bottom Apps Suite Strip (13 Microsoft Apps) -->
        <!-- ==================================================== -->
        <div class="mt-12 sm:mt-16 pt-2">
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-7 lg:grid-cols-[repeat(13,minmax(0,1fr))] gap-1.5 sm:gap-3 items-center text-center">

                <!-- 1. Copilot -->
                <a href="#key-features" data-aos="fade-up" data-aos-delay="50" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/copilot.png') }}" alt="Copilot" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Copilot</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">AI assistant</span>
                </a>

                <!-- 2. Word -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="100" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/word.png') }}" alt="Word" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Word</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Create & edit</span>
                </a>

                <!-- 3. Excel -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="150" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/excel.png') }}" alt="Excel" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Excel</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Analyze & visualize</span>
                </a>

                <!-- 4. PowerPoint -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="200" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/powerpoint.png') }}" alt="PowerPoint" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">PowerPoint</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Present ideas</span>
                </a>

                <!-- 5. Outlook -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="250" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/outlook.png') }}" alt="Outlook" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Outlook</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Email & calendar</span>
                </a>

                <!-- 6. Teams -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="300" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/teams.png') }}" alt="Teams" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Teams</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Meet & collaborate</span>
                </a>

                <!-- 7. OneDrive -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="350" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/onedrive.png') }}" alt="OneDrive" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">OneDrive</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Cloud storage</span>
                </a>

                <!-- 8. SharePoint -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="400" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/sharepoint.png') }}" alt="SharePoint" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">SharePoint</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Content management</span>
                </a>

                <!-- 9. OneNote -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="450" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/Onenote.png') }}" alt="OneNote" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">OneNote</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Take notes</span>
                </a>

                <!-- 10. Forms -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="500" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/forms.png') }}" alt="Forms" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Forms</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Create surveys</span>
                </a>

                <!-- 11. Planner -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="550" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/planner.png') }}" alt="Planner" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Planner</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Plan & organize</span>
                </a>

                <!-- 12. Power Automate -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="600" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/power-automate.png') }}" alt="Power Automate" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Power Automate</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Automate workflows</span>
                </a>

                <!-- 13. Power BI -->
                <a href="#included-apps" data-aos="fade-up" data-aos-delay="650" class="flex flex-col items-center justify-center group p-2 sm:p-2.5 rounded-2xl border border-transparent hover:border-white/80 dark:hover:border-slate-700/80 hover:bg-white/70 dark:hover:bg-slate-900/70 hover:backdrop-blur-md hover:shadow-xl hover:shadow-slate-300/40 dark:hover:shadow-slate-950/60 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center mb-1.5 sm:mb-2">
                        <img src="{{ asset('assets/img/products/power-bi.png') }}" alt="Power BI" class="w-7 h-7 sm:w-8 sm:h-8 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900 dark:text-white leading-tight">Power BI</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-full">Business insights</span>
                </a>

            </div>
        </div>
        @endif

    </div>
</section>

<!-- ========================================== -->
<!-- 2. KEY FEATURES SECTION                    -->
<!-- ========================================== -->
<section id="key-features" class="py-12 sm:py-16 bg-[#f8fafc] dark:bg-slate-900/60 border-t border-slate-200/80 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="mb-8 sm:mb-10" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Key features
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-1.5 font-normal">
                Everything you need to be productive, secure, and connected.
            </p>
        </div>

        <!-- Dynamic Feature Cards Grid (3 Columns) - Compact -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @forelse($keyFeatures ?? [] as $index => $feature)
                @php
                    $bgClass = match($feature->icon_bg_color) {
                        'purple' => 'bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400',
                        'indigo' => 'bg-indigo-50 dark:bg-indigo-950/50 text-[#5059c9] dark:text-indigo-400',
                        'blue' => 'bg-blue-50 dark:bg-blue-950/50 text-[#0078d4] dark:text-sky-400',
                        'amber' => 'bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400',
                        'emerald' => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400',
                        'rose' => 'bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400',
                        default => 'bg-sky-50 dark:bg-sky-950/50 text-[#0078d4] dark:text-sky-400',
                    };
                @endphp
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700 p-5 sm:p-6 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-lg hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
                    <div>
                        <!-- Icon -->
                        <div class="w-9 h-9 rounded-lg {{ $bgClass }} flex items-center justify-center mb-3.5 text-base">
                            <i class="{{ $feature->icon }}"></i>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {{ $feature->title }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed mt-1.5">
                            {{ $feature->description }}
                        </p>

                        <!-- Link -->
                        <a href="{{ $feature->link_url ?? '#plans' }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#0067b8] dark:text-sky-400 hover:text-brand-700 dark:hover:text-sky-300 mt-3 group-hover:gap-2 transition-all">
                            <span>{{ $feature->link_text ?? 'Learn more' }}</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>

                    <!-- Full Image Container -->
                    @if($feature->image)
                    <div class="mt-4 rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800">
                        <img src="{{ asset($feature->image) }}" alt="{{ $feature->title }}" class="w-full h-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </div>
                    @endif
                </div>
            @empty
                <!-- Fallback static card if database is empty -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/90 dark:border-slate-700 p-5 sm:p-6 flex flex-col justify-between overflow-hidden shadow-sm">
                    <div>
                        <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-950/50 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-3.5 text-base">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white tracking-tight">AI-powered productivity</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed mt-1.5">Get real-time assistance with Microsoft 365 Copilot.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</section>

    </div>
</section>

<!-- ============================================================ -->
<!-- 3. INTEGRATED EXPERIENCE (Microsoft 365 Floating App Galaxy) -->
<!-- ============================================================ -->
<section id="integrated-experience" class="py-10 sm:py-14 lg:py-16 bg-[#fafbfc] dark:bg-slate-950 border-t border-slate-200/80 dark:border-slate-800 relative overflow-hidden">
    <!-- Full Background Image Layer with subtle fade (Positioned to Right) -->
    <div class="absolute inset-0 bg-no-repeat bg-right-top sm:bg-right bg-cover sm:bg-contain pointer-events-none opacity-85 sm:opacity-90 dark:opacity-30 transition-all duration-300" style="background-image: url('{{ asset('assets/img/Microsoft 365 Floating App Galaxy.png') }}'); background-position: right center;"></div>

    <!-- Soft Left-to-Right and Top/Bottom Fade Gradients for smooth blending -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#fafbfc] via-[#fafbfc]/80 to-transparent dark:from-slate-950 dark:via-slate-950/85 dark:to-transparent lg:w-1/2 pointer-events-none"></div>
    <div class="absolute inset-x-0 top-0 h-8 bg-gradient-to-b from-[#fafbfc] dark:from-slate-950 to-transparent pointer-events-none"></div>
    <div class="absolute inset-x-0 bottom-0 h-8 bg-gradient-to-t from-[#fafbfc] dark:from-slate-950 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-lg text-left" data-aos="fade-top">
            <h2 class="text-2xl sm:text-3xl lg:text-[32px] font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.2]">
                Your favorite apps<br>
                <span class="text-[#0067b8] dark:text-sky-400">in one integrated experience</span>
            </h2>

            <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed mt-2.5">
                Create, edit, collaborate, and share with the apps you know and love, now with even more powerful features.
            </p>

            <div class="pt-4 sm:pt-5">
                <a href="#included-apps" class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl border-2 border-[#0067b8] dark:border-sky-400 text-[#0067b8] dark:text-sky-300 hover:bg-[#0067b8] hover:text-white dark:hover:bg-sky-500 dark:hover:text-slate-950 font-bold text-xs sm:text-sm transition-all duration-200 shadow-sm hover:shadow-md group active:scale-95 cursor-pointer bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm">
                    <span>Explore all apps</span>
                    <i class="fa-solid fa-arrow-right text-[11px] transition-transform duration-200 group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================= -->
<!-- WHAT'S INCLUDED: POWERFUL APPS SECTION (Official MS UI) -->
<!-- ======================================================= -->
<section id="included-apps" class="py-16 lg:py-24 bg-[#faf8f5] dark:bg-slate-950 border-t border-[#ede7df] dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Header & Filter Row -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12" data-aos="fade-up">
            <div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-500 dark:text-slate-400 block mb-1">
                    WHAT'S INCLUDED
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    Powerful apps to simplify your<br class="hidden sm:inline"> life and work
                </h2>

                <!-- App Category Pill Switcher -->
                <div class="flex items-center gap-2 mt-6">
                    <button onclick="switchAppTab('productivity')" id="tab-btn-productivity" class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 dark:bg-sky-500 text-white dark:text-slate-950 shadow-sm cursor-pointer">
                        Productivity Apps
                    </button>
                    <button onclick="switchAppTab('security')" id="tab-btn-security" class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 cursor-pointer">
                        Security & Storage Apps
                    </button>
                </div>
            </div>

            <!-- Explore All Apps Link -->
            <div class="hidden sm:flex items-center">
                <a href="#plans" class="inline-flex items-center gap-2 text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:text-[#005da6] dark:hover:text-sky-300 group">
                    <span class="w-6 h-6 rounded-full bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center text-[10px] group-hover:bg-[#0067b8] dark:group-hover:bg-sky-500 transition-colors">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                    <span>Explore all apps</span>
                </a>
            </div>
        </div>

        <!-- 1. Productivity Apps Grid -->
        <div id="grid-productivity" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($productivityApps ?? [] as $index => $app)
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between hover:shadow-lg hover:border-slate-300 dark:hover:border-slate-700 transition-all group" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
                    <div>
                        <div class="w-10 h-10 mb-4 flex items-center justify-center">
                            @if($app->icon_image)
                                <img src="{{ asset($app->icon_image) }}" class="w-full h-full object-contain" alt="{{ $app->name }}">
                            @else
                                <i class="fa-solid fa-shapes text-slate-400 text-2xl"></i>
                            @endif
                        </div>
                        <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">{{ $app->name }}</span>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2.5 leading-snug">
                            {{ $app->tagline }}
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $app->description }}
                        </p>
                    </div>
                    <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ $app->link_url ?? '#plans' }}" @if(str_starts_with($app->link_url ?? '', 'http')) target="_blank" @endif class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 underline underline-offset-4 decoration-slate-300 dark:decoration-slate-700 hover:decoration-[#0067b8] dark:hover:decoration-sky-400 transition-colors">
                            <span>{{ $app->link_text ?? 'Learn more' }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No productivity apps configured yet.
                </div>
            @endforelse
        </div>

        <!-- 2. Security & Storage Apps Grid (Tab 2) -->
        <div id="grid-security" class="hidden grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($securityApps ?? [] as $index => $app)
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between hover:shadow-lg transition-all" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
                    <div>
                        <div class="w-10 h-10 mb-4 flex items-center justify-center">
                            @if($app->icon_image)
                                <img src="{{ asset($app->icon_image) }}" class="w-full h-full object-contain" alt="{{ $app->name }}">
                            @else
                                <i class="fa-solid fa-shield-halved text-slate-400 text-2xl"></i>
                            @endif
                        </div>
                        <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">{{ $app->name }}</span>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug">{{ $app->tagline }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $app->description }}</p>
                    </div>
                    <div class="mt-8 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ $app->link_url ?? '#plans' }}" @if(str_starts_with($app->link_url ?? '', 'http')) target="_blank" @endif class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 underline underline-offset-4 decoration-slate-300 dark:decoration-slate-700 hover:decoration-[#0067b8] dark:hover:decoration-sky-400 transition-colors">
                            <span>{{ $app->link_text ?? 'Learn more' }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No security & storage apps configured yet.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 3. PRICING & PLANS (2 Annual Plans)        -->
<!-- ========================================== -->
<section id="plans" class="py-16 lg:py-24 bg-white dark:bg-slate-900 relative border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 px-3.5 py-1 rounded-full border border-sky-100 dark:border-sky-800">
                Official Microsoft Pricing & Licensing
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-3">
                Choose the plan that's right for you
            </h2>
            <p class="text-slate-600 dark:text-slate-400 mt-2 text-sm sm:text-base">
                Transparent Annual Subscription in Bangladesh. Instant license activation via bKash, Nagad & Cards.
            </p>
        </div>

        <!-- Dynamic Plan Cards Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto items-stretch">
            @forelse($plans as $plan)
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl {{ $plan->is_featured ? 'border-2 border-[#0067b8] dark:border-sky-500 shadow-xl hover:shadow-2xl' : 'border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600' }} p-8 sm:p-9 pt-10 flex flex-col justify-between transition-all relative mt-4 md:mt-0" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">

                @if($plan->badge)
                <div class="absolute -top-3.5 left-8 bg-[#0067b8] dark:bg-sky-500 text-white text-[11px] font-bold uppercase px-4 py-1 rounded-full tracking-wider shadow-md z-20 flex items-center gap-1.5 border border-white/40 dark:border-slate-900/40">
                    <i class="fa-solid fa-fire text-amber-300 dark:text-amber-200 text-xs"></i>
                    <span>{{ $plan->badge }}</span>
                </div>
                @endif

                <div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $plan->name }}</h3>

                    <!-- Price -->
                    <div class="mt-4 mb-1">
                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white">{{ $plan->price_bdt }}</span>
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">/{{ $plan->billing_period }}</span>
                        @if($plan->price_usd)
                        <span class="text-xs text-slate-400 dark:text-slate-500 font-normal ml-1">({{ $plan->price_usd }})</span>
                        @endif
                    </div>

                    @if($plan->terms_text)
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                        {{ $plan->terms_text }}
                    </p>
                    @endif

                    <!-- Action Button -->
                    <div class="mb-8">
                        <a href="{{ route('user.checkout', ['plan' => $plan->id]) ?? '#order' }}" target="_blank" class="w-full {{ $plan->is_featured ? 'bg-[#0067b8] hover:bg-[#005da6] dark:bg-sky-600 dark:hover:bg-sky-500 text-white shadow-md hover:shadow-lg' : 'bg-[#0f172a] dark:bg-slate-700 hover:bg-[#0067b8] dark:hover:bg-sky-600 text-white shadow-sm hover:shadow-md' }} font-bold px-7 py-3.5 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 group">
                            <span>{{ $plan->button_text }}</span>
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="h-px bg-slate-200/80 dark:bg-slate-700 mb-6"></div>

                    <!-- Features List -->
                    <div class="space-y-3.5 text-xs text-slate-700 dark:text-slate-300">
                        @if($plan->features_heading)
                        <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $plan->features_heading }}</p>
                        @endif

                        @if(is_array($plan->features))
                        @foreach($plan->features as $feature)
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-check {{ $plan->is_featured ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-800 dark:text-slate-200' }} text-xs mt-0.5 shrink-0"></i>
                            <span>{!! $feature !!}</span>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Bottom Included App Logos Strip -->
                @if(!empty($plan->included_apps) && is_array($plan->included_apps))
                <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-700 flex flex-wrap items-center gap-2">
                    @foreach($plan->included_apps as $appKey)
                    <img src="{{ asset('assets/img/products/' . strtolower($appKey) . '.png') }}" class="w-6 h-6 object-contain" alt="{{ ucfirst($appKey) }}" title="{{ ucfirst($appKey) }}">
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-2 py-12 text-center text-slate-400">
                No active pricing plans configured yet.
            </div>
            @endforelse
        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 5. HOW IT WORKS: 4 STEPS (Cream White Theme) -->
<!-- ========================================== -->
<section id="how-it-works" class="py-16 lg:py-24 bg-[#fcfaf7] dark:bg-slate-950 text-slate-900 dark:text-slate-100 border-t border-b border-[#ece6de] dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <span class="text-xs font-extrabold uppercase tracking-widest text-[#0067b8] dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 border border-sky-200/80 dark:border-sky-800 px-3.5 py-1 rounded-full">
                Seamless 4-Step Activation
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-3">
                How It Works
            </h2>
            <p class="text-slate-600 dark:text-slate-400 mt-2 text-xs sm:text-sm">
                Get instant access to your Microsoft 365 license, 1TB cloud, and Copilot AI in four simple steps.
            </p>
        </div>

        <!-- Dynamic Step Cards Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($howItWorks ?? [] as $index => $step)
            @php
            $iconColorTheme = $step->icon_bg_color ?? 'sky';
            $badgeColorTheme = $step->badge_color ?? 'emerald';

            $iconClass = match($iconColorTheme) {
            'purple' => 'bg-purple-50 dark:bg-slate-800 border-purple-100 dark:border-slate-700 text-purple-600 dark:text-purple-400',
            'amber' => 'bg-amber-50 dark:bg-slate-800 border-amber-100 dark:border-slate-700 text-amber-600 dark:text-amber-400',
            'emerald' => 'bg-emerald-50 dark:bg-slate-800 border-emerald-100 dark:border-slate-700 text-emerald-600 dark:text-emerald-400',
            'rose' => 'bg-rose-50 dark:bg-slate-800 border-rose-100 dark:border-slate-700 text-rose-600 dark:text-rose-400',
            'blue' => 'bg-blue-50 dark:bg-slate-800 border-blue-100 dark:border-slate-700 text-blue-600 dark:text-blue-400',
            default => 'bg-sky-50 dark:bg-slate-800 border-sky-100 dark:border-slate-700 text-[#0067b8] dark:text-sky-400',
            };

            $badgeTextClass = match($badgeColorTheme) {
            'amber' => 'text-amber-600 dark:text-amber-400',
            'purple' => 'text-purple-600 dark:text-purple-400',
            'sky', 'blue' => 'text-[#0067b8] dark:text-sky-400',
            'rose' => 'text-rose-600 dark:text-rose-400',
            default => 'text-emerald-600 dark:text-emerald-400',
            };

            $badgeIconClass = match($badgeColorTheme) {
            'amber' => 'text-amber-500',
            'purple' => 'text-purple-500',
            'sky', 'blue' => 'text-[#0067b8] dark:text-sky-400',
            'rose' => 'text-rose-500',
            default => 'text-emerald-500',
            };
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-[#e8e2d8] dark:border-slate-800 shadow-sm hover:shadow-md hover:border-[#0067b8] dark:hover:border-sky-400 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
                <div>
                    <div class="w-12 h-12 rounded-xl border flex items-center justify-center text-xl mb-5 shadow-xs {{ $iconClass }}">
                        <i class="{{ $step->icon ?? 'fa-solid fa-layer-group' }}"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-base mb-1.5">{{ $step->title }}</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $step->description }}
                    </p>
                </div>
                @if($step->badge_text)
                <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-semibold flex items-center gap-1.5 {{ $badgeTextClass }}">
                    <i class="{{ $step->badge_icon ?? 'fa-solid fa-circle-check' }} {{ $badgeIconClass }}"></i>
                    <span>{{ $step->badge_text }}</span>
                </div>
                @endif
            </div>
            @empty
            <!-- Fallback if none in database -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-[#e8e2d8] dark:border-slate-800 shadow-sm hover:shadow-md hover:border-[#0067b8] dark:hover:border-sky-400 transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 dark:bg-slate-800 border border-sky-100 dark:border-slate-700 flex items-center justify-center text-[#0067b8] dark:text-sky-400 text-xl mb-5 shadow-xs">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-base mb-1.5">Choose Plan</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Select the Microsoft 365 plan designed for your individual use, family, or enterprise business.</p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Instant Selection
                </div>
            </div>
            @endforelse
        </div>

    </div>
</section>

<!-- ============================================================ -->
<!-- 6. TRUSTED BY MILLIONS AROUND THE WORLD                      -->
<!-- ============================================================ -->
<section id="trusted-by" class="py-12 sm:py-16 bg-white dark:bg-slate-950 border-t border-slate-200/80 dark:border-slate-800 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <!-- Title & Subtitle -->
        <div class="max-w-3xl mx-auto mb-9 sm:mb-12" data-aos="fade-up">
            <h3 class="text-xl sm:text-2xl lg:text-[26px] font-extrabold text-slate-900 dark:text-white tracking-tight">
                Trusted by millions around the world
            </h3>
            <p class="text-slate-600 dark:text-slate-400 mt-1 sm:mt-1.5 text-xs sm:text-sm">
                Over 300 million people and organizations use Microsoft 365 to achieve more.
            </p>
        </div>

        <!-- Global Brands Logos Owl Carousel -->
        <div class="owl-carousel trusted-brands-carousel" data-aos="fade-up" data-aos-delay="100">
            @forelse($trustedBrands ?? [] as $brand)
                <div class="flex items-center justify-center h-14 sm:h-16 px-2">
                    @if($brand->website_url)
                        <a href="{{ $brand->website_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center group hover:scale-105 transition-all duration-300 w-full h-full" title="{{ $brand->name }}">
                            <img src="{{ asset($brand->logo_image) }}" alt="{{ $brand->name }}" class="h-6 sm:h-7.5 md:h-8 max-w-[130px] sm:max-w-[150px] w-auto mx-auto object-contain filter drop-shadow-2xs dark:brightness-110 transition-transform duration-300 group-hover:scale-105">
                        </a>
                    @else
                        <div class="flex items-center justify-center group hover:scale-105 transition-all duration-300 w-full h-full" title="{{ $brand->name }}">
                            <img src="{{ asset($brand->logo_image) }}" alt="{{ $brand->name }}" class="h-6 sm:h-7.5 md:h-8 max-w-[130px] sm:max-w-[150px] w-auto mx-auto object-contain filter drop-shadow-2xs dark:brightness-110 transition-transform duration-300 group-hover:scale-105">
                        </div>
                    @endif
                </div>
            @empty
                <div class="py-4 text-center text-xs text-slate-400">
                    Trusted brands will appear here.
                </div>
            @endforelse
        </div>

    </div>
</section>



<!-- ======================================================= -->
<!-- EXPLORE EVEN MORE BENEFITS SECTION (Dynamic Grid)        -->
<!-- ======================================================= -->
<section id="more-benefits" class="py-16 lg:py-24 bg-[#faf8f5] dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Title -->
        <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Explore even more benefits of Microsoft 365
            </h2>
            <p class="text-slate-600 dark:text-slate-400 mt-2 text-sm sm:text-base">
                Everything you need to create, collaborate, communicate, and stay secure across all your devices.
            </p>
        </div>

        <!-- Dynamic Benefit Cards Grid (2 rows x 3 columns) -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7 max-w-6xl mx-auto">
            @forelse($moreBenefits ?? [] as $index => $benefit)
                <div class="bg-white dark:bg-slate-800/90 rounded-3xl p-7 border border-slate-200/90 dark:border-slate-700 shadow-sm hover:shadow-md hover:border-slate-300 dark:hover:border-slate-600 transition-all flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ 50 * ($index + 1) }}">
                    <div>
                        <div class="w-12 h-12 mb-5 flex items-center justify-center">
                            @if($benefit->icon_image)
                                <img src="{{ asset($benefit->icon_image) }}" class="w-full h-full object-contain" alt="{{ $benefit->title }}">
                            @else
                                <i class="fa-solid fa-layer-group text-slate-400 text-2xl"></i>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2.5">
                            {{ $benefit->title }}
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $benefit->description }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No benefit cards configured yet.
                </div>
            @endforelse
        </div>

    </div>
</section>

    </div>
</section>


<!-- ============================================================ -->
<!-- 7. WORK FROM ANYWHERE ON ANY DEVICE                          -->
<!-- ============================================================ -->
<section id="work-from-anywhere" class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800 overflow-hidden relative">
    <!-- Ambient Background Glow -->
    <div class="absolute top-1/2 left-0 -translate-y-1/2 w-96 h-96 bg-blue-400/10 dark:bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">

            <!-- Left Column: Visual Mockup with Devices Image -->
            <div class="lg:col-span-7 relative flex items-center justify-center lg:justify-start" data-aos="fade-top">
                <div class="relative w-full max-w-2xl group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-blue-400/15 via-purple-400/10 to-cyan-400/15 rounded-3xl blur-2xl opacity-70 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                    <img src="{{ asset('assets/img/Microsoft 365 Dashboard Across Devices.png') }}" alt="Work from anywhere on any device" class="relative z-10 w-full h-auto object-contain drop-shadow-2xl transition-transform duration-500 group-hover:scale-[1.02]">
                </div>
            </div>

            <!-- Right Column: Content -->
            <div class="lg:col-span-5 space-y-4 sm:space-y-6 text-left" data-aos="fade-top" data-aos-delay="100">
                <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.18]">
                    Work from anywhere<br>
                    <span>on any device</span>
                </h2>

                <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg leading-relaxed max-w-xl">
                    Stay productive whether you're at home, in the office, or on the go. Microsoft 365 works seamlessly across Windows, macOS, iOS, and Android.
                </p>

                <div class="pt-2 sm:pt-4">
                    <a href="#plans" class="inline-flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl border-2 border-[#0067b8] dark:border-sky-400 text-[#0067b8] dark:text-sky-300 hover:bg-[#0067b8] hover:text-white dark:hover:bg-sky-500 dark:hover:text-slate-950 font-bold text-sm sm:text-base transition-all duration-200 shadow-sm hover:shadow-md group active:scale-95 cursor-pointer">
                        <span>Learn more</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ======================================================= -->
<!-- AI FEATURES SECTION: SLIDER / CAROUSEL (Cream Background) -->
<!-- ======================================================= -->
<section id="ai-features" class="py-16 lg:py-24 bg-[#f8f6f2] dark:bg-slate-950 border-t border-[#ede7df] dark:border-slate-800 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header and Navigation Controls -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10" data-aos="fade-up">
            <div class="max-w-2xl">
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-500 dark:text-slate-400 block mb-1">
                    INTELLIGENT CAPABILITIES
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    Smart AI capabilities in Microsoft 365 to accelerate your work, research, and ideas
                </h2>
            </div>

            <!-- Carousel Controls -->
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="scrollAiSlider('left')" aria-label="Previous" class="w-10 h-10 rounded-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 flex items-center justify-center transition-all shadow-xs active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <button onclick="scrollAiSlider('right')" aria-label="Next" class="w-10 h-10 rounded-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 flex items-center justify-center transition-all shadow-xs active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Horizontal Scrollable Feature Cards (Dynamic) -->
        <div id="ai-slider-container" class="flex gap-6 overflow-x-auto pb-6 scroll-smooth snap-x snap-mandatory no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
            @forelse($aiFeatures ?? [] as $index => $feature)
                <div class="w-[300px] sm:w-[340px] shrink-0 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-lg transition-all snap-start group">
                    <div>
                        <!-- Visual Header Image -->
                        <div class="h-52 w-full overflow-hidden border-b border-slate-100 dark:border-slate-800/80 bg-slate-100 dark:bg-slate-800">
                            @if($feature->image)
                                <img src="{{ asset($feature->image) }}" class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105" alt="{{ $feature->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-robot text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Body Content -->
                        <div class="p-6">
                            @if($feature->badge)
                                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">{{ $feature->badge }}</span>
                            @endif
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors">
                                {{ $feature->title }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $feature->description }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-2">
                        <a href="{{ $feature->link_url ?? '#plans' }}" @if(str_starts_with($feature->link_url ?? '', 'http')) target="_blank" @endif class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 group/link">
                            <span class="w-6 h-6 rounded-full bg-slate-900 dark:bg-slate-800 group-hover/link:bg-[#0067b8] dark:group-hover/link:bg-sky-500 text-white flex items-center justify-center text-[10px] transition-colors">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                            <span>{{ $feature->link_text ?? 'See Copilot plans' }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                    No AI features configured yet.
                </div>
            @endforelse
        </div>

    </div>
</section>

    </div>
</section>



<!-- ========================================== -->
<!-- 8. GET APPS / MULTI-DEVICE (Official MS Style) -->
<!-- ========================================== -->
<section class="py-14 lg:py-18 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Download Microsoft 365
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2">
                Available across all your devices — PC, Mac, iPhone, iPad, and Android.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto items-stretch">

            <!-- Desktop Download Card -->
            <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-[#e8e2d8] dark:border-slate-700 p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-[#0067b8] dark:hover:border-sky-400 transition-all" data-aos="fade-up" data-aos-delay="50">
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-lg mb-1">
                        Download for PC & Mac
                    </h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                        Get the full desktop apps for your computer including Word, Excel, PowerPoint, and Outlook.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex flex-wrap items-center gap-3">
                    <a href="https://www.microsoft.com/microsoft-365/download-office" target="_blank" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] dark:bg-sky-600 dark:hover:bg-sky-500 text-white text-xs font-bold px-5 py-3 rounded-xl flex items-center justify-center gap-2.5 transition-colors shadow-xs">
                        <i class="fa-solid fa-download text-sm"></i>
                        <span>Download for PC / Mac</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Download Card -->
            <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-[#e8e2d8] dark:border-slate-700 p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-md hover:border-[#0067b8] dark:hover:border-sky-400 transition-all" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-lg mb-1">
                        Download for Mobile
                    </h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                        Stay productive on the go. Install the Microsoft 365 app directly from your mobile store.
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex flex-wrap items-center gap-3">
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

<!-- ============================================================ -->
<!-- 9. READY TO GET STARTED BANNER (Pastel Aurora Ribbon Waves)  -->
<!-- ============================================================ -->
@if(site_is_enabled('cta_banner_enabled', true))
<section class="w-full relative overflow-hidden bg-gradient-to-r from-[#eef4fd] via-[#f1f6fd] to-[#e4eefb] dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 border-t border-b border-slate-200/90 dark:border-slate-800 min-h-[300px] sm:min-h-[340px] flex items-center justify-center">

    <!-- Background Aurora Ribbon Waves (Right Aligned Edge-to-Edge) -->
    <div class="absolute inset-0 bg-no-repeat bg-right bg-cover sm:bg-contain pointer-events-none opacity-90 sm:opacity-95 dark:opacity-35 transition-all duration-300" style="background-image: url('{{ site_file_url('cta_banner_bg_image', 'assets/img/Pastel Aurora Ribbon Waves.png') }}'); background-position: right center;"></div>

    <!-- Soft Ambient Fade Overlay to ensure crisp text readability in center -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#eef4fd]/90 via-[#eef4fd]/70 to-transparent dark:from-slate-900/95 dark:via-slate-900/70 dark:to-transparent pointer-events-none"></div>

    <!-- Content Area (Centered) -->
    <div class="relative z-10 w-full max-w-4xl mx-auto px-6 sm:px-10 lg:px-16 py-12 sm:py-16 lg:py-20 text-center" data-aos="fade-up">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-[42px] font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.18]">
            {{ site_setting('cta_banner_title', 'Ready to get started with Microsoft 365?') }}
        </h2>

        <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm md:text-base mt-2.5 sm:mt-3 max-w-xl mx-auto leading-relaxed">
            {{ site_setting('cta_banner_description', 'Join millions of people and organizations who are doing more with Microsoft 365.') }}
        </p>

        <!-- Action Buttons (Centered) -->
        <div class="flex flex-wrap items-center justify-center gap-3.5 sm:gap-4 pt-6 sm:pt-7">
            <a href="{{ site_setting('cta_banner_btn1_url', '#plans') }}" class="inline-flex items-center justify-center gap-2 bg-[#0067b8] hover:bg-[#005da6] dark:bg-sky-600 dark:hover:bg-sky-500 text-white font-bold text-xs sm:text-sm px-6 sm:px-7 py-3 rounded-lg shadow-sm hover:shadow-md transition-all active:scale-95 cursor-pointer group">
                <span>{{ site_setting('cta_banner_btn1_text', 'Get Microsoft 365') }}</span>
                <i class="fa-solid fa-arrow-right text-[11px] transition-transform duration-200 group-hover:translate-x-1"></i>
            </a>

            <a href="{{ site_setting('cta_banner_btn2_url', '#plans') }}" class="inline-flex items-center justify-center bg-white/90 dark:bg-slate-800/90 hover:bg-white dark:hover:bg-slate-800 text-[#0067b8] dark:text-sky-300 border border-[#0067b8] dark:border-sky-500/80 font-bold text-xs sm:text-sm px-6 sm:px-7 py-3 rounded-lg shadow-xs hover:shadow-sm transition-all active:scale-95 cursor-pointer backdrop-blur-xs">
                <span>{{ site_setting('cta_banner_btn2_text', 'Compare plans') }}</span>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ========================================== -->
<!-- 10. DID YOU KNOW? FAQ (From PDF 2 & PDF 3) -->
<!-- ========================================== -->
<section id="faq" class="py-16 lg:py-24 bg-[#faf8f5] dark:bg-slate-950 border-t border-[#ede7df] dark:border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-12">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Did you know?</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Frequently asked questions about Microsoft 365 subscriptions in Bangladesh.</p>
            </div>
            <button onclick="toggleAllFaqs()" id="btn-toggle-all-faq" class="text-xs font-bold text-brand-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 border border-sky-100 dark:border-sky-800 px-3.5 py-1.5 rounded-lg hover:bg-sky-100 dark:hover:bg-sky-900/60 transition-colors cursor-pointer">
                Expand all
            </button>
        </div>

        <!-- Numbered Accordion (Microsoft 365 + Copilot Official FAQ) -->
        <div class="space-y-6">

            @forelse($faqs as $faq)
                <div class="border-b border-slate-200 dark:border-slate-800 pb-6">
                    <button onclick="toggleFaq({{ $faq->id }})" class="w-full text-left font-bold text-slate-900 dark:text-white flex justify-between items-center gap-6 py-2 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors group cursor-pointer">
                        <div class="flex items-start gap-4">
                            <span class="text-xs font-mono font-bold text-slate-400 dark:text-slate-500 pt-0.5">{{ sprintf('%02d/', $faq->sort_order ?: $loop->iteration) }}</span>
                            <span class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors">
                                {{ $faq->question }}
                            </span>
                        </div>
                        <div class="w-7 h-7 rounded-lg bg-slate-900 dark:bg-slate-800 text-white dark:text-slate-200 flex items-center justify-center text-xs shadow-xs shrink-0">
                            <span id="faq-sign-{{ $faq->id }}" class="font-bold">{{ $faq->is_default_open ? '−' : '+' }}</span>
                        </div>
                    </button>
                    <div id="faq-answer-{{ $faq->id }}" class="{{ $faq->is_default_open ? '' : 'hidden' }} pl-10 pr-4 pt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        {!! $faq->answer !!}
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-sm text-slate-500 dark:text-slate-400">No frequently asked questions available right now.</p>
                </div>
            @endforelse

        </div>

    </div>
</section>

<!-- ========================================== -->
<!-- 10. CONTACT & SUPPORT HUB (Clean White Theme) -->
<!-- ========================================== -->
<section id="contact-support" class="py-16 lg:py-24 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            <!-- Left Bio & Hotlines -->
            <div class="lg:col-span-6 space-y-6" data-aos="fade-up">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-[#0067b8] dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 px-3.5 py-1 rounded-full border border-sky-200 dark:border-sky-800">
                    <i class="fa-solid fa-building-shield text-xs"></i> About Microsoft 365 Reseller BD
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    Empowering individuals & teams with frictionless Microsoft 365 access.
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                    Built to eliminate high international credit card currency exchange fees, complex foreign invoicing, and scattered renewals. Get genuine Microsoft subscriptions delivered directly to your personal or company account with trusted local bKash, Nagad, and banking channels.
                </p>

                <div class="space-y-3 text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium">
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base shrink-0"></i>
                        <span>Direct integration with bKash, Nagad & Bangladeshi Banking Rails</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base shrink-0"></i>
                        <span>Zero duplicate active packages — automated validity stacking</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base shrink-0"></i>
                        <span>Comprehensive audit trail & downloadable local VAT Tax Invoices</span>
                    </p>
                </div>

                <!-- Direct Contact Cards -->
                <div class="grid sm:grid-cols-2 gap-4 pt-3">
                    <a href="tel:{{ site_setting('contact_phone_raw', '+88096490123756') }}" class="p-4 bg-white dark:bg-slate-800/90 rounded-2xl border border-[#e8e2d8] dark:border-slate-700 shadow-xs hover:shadow-md hover:border-[#0067b8] dark:hover:border-sky-400 transition-all flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-sky-50 dark:bg-slate-800 border border-sky-100 dark:border-slate-700 flex items-center justify-center text-[#0067b8] dark:text-sky-400 text-lg shrink-0 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-bold tracking-wider">Customer Support</p>
                            <p class="text-sm font-extrabold text-slate-900 dark:text-white">{{ site_setting('contact_phone', '096490123756') }}</p>
                        </div>
                    </a>

                    <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello I want to order Microsoft 365 Subscription')) }}" target="_blank" class="p-4 bg-white dark:bg-slate-800/90 rounded-2xl border border-[#e8e2d8] dark:border-slate-700 shadow-xs hover:shadow-md hover:border-emerald-500 dark:hover:border-emerald-400 transition-all flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-slate-800 border border-emerald-100 dark:border-slate-700 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-lg shrink-0 group-hover:scale-105 transition-transform">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-bold tracking-wider">WhatsApp Support</p>
                            <p class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400">{{ site_setting('whatsapp_number', '+880 1342-325558') }}</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Right Contact Form Card -->
            <div class="lg:col-span-6 bg-white dark:bg-slate-800 rounded-3xl p-7 sm:p-9 border border-[#e8e2d8] dark:border-slate-700 shadow-lg" data-aos="fade-up">
                <span class="text-xs font-extrabold uppercase tracking-wider text-[#0067b8] dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 px-3 py-1 rounded-full border border-sky-100 dark:border-sky-800 inline-block mb-3">
                    Contact Us
                </span>
                <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-1.5">Get In Touch</h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-6">Have questions regarding packages, renewals, or enterprise licenses? Send us a note.</p>

                <form id="storefront-contact-form" onsubmit="handleContactSubmit(event)" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Your Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="contact-name" name="name" placeholder="e.g. Tanvir Hasan" required class="w-full bg-[#fbf9f6] dark:bg-slate-900 border border-slate-300/80 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" id="contact-email" name="email" placeholder="name@domain.com" required class="w-full bg-[#fbf9f6] dark:bg-slate-900 border border-slate-300/80 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Phone / WhatsApp Number</label>
                            <input type="text" id="contact-phone" name="phone" placeholder="017XXXXXXXX" class="w-full bg-[#fbf9f6] dark:bg-slate-900 border border-slate-300/80 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Message / Requirement <span class="text-rose-500">*</span></label>
                        <textarea id="contact-message" name="message" rows="3" placeholder="How can our Microsoft team assist you today?" required class="w-full bg-[#fbf9f6] dark:bg-slate-900 border border-slate-300/80 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-900 transition-all"></textarea>
                    </div>

                    <button type="submit" id="contact-submit-btn" class="w-full bg-[#0067b8] hover:bg-[#005da6] dark:bg-sky-600 dark:hover:bg-sky-500 text-white font-bold py-3.5 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg cursor-pointer">
                        <i id="contact-btn-icon" class="fa-regular fa-paper-plane text-xs"></i>
                        <span id="contact-btn-text">Send Message</span>
                    </button>
                    <div id="contact-status" class="hidden text-center text-xs font-semibold p-3 rounded-xl"></div>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 11. BOTTOM CTA (Microsoft Enterprise Style) -->
<!-- ========================================== -->
<section class="py-16 sm:py-20 lg:py-24 bg-[#0a1128] dark:bg-slate-950 text-white text-center relative overflow-hidden border-t border-slate-800">
    <!-- Full Background Image Layer -->
    <div class="absolute inset-0 bg-no-repeat bg-center bg-cover pointer-events-none opacity-90 transition-opacity" style="background-image: url('{{ asset('assets/img/Microsoft 365 Glassmorphism Wave Banner.png') }}');"></div>

    <!-- Soft Ambient Backdrop / Gradient Overlay to ensure text & buttons stand out crystal clear -->
    <div class="absolute inset-0 bg-slate-950/40 dark:bg-slate-950/60 backdrop-blur-[2px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-3 drop-shadow-md">
            Ready to upgrade your Microsoft 365 licensing?
        </h2>
        <p class="text-slate-200 dark:text-slate-300 text-xs sm:text-sm max-w-2xl mx-auto mb-8 leading-relaxed drop-shadow-sm font-medium">
            Get instant access to genuine Microsoft cloud subscriptions, 1TB OneDrive storage, and full Office desktop apps with local bKash, Nagad, and Bangladeshi bank checkout.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5">
            <a href="#plans" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005da6] dark:bg-sky-600 dark:hover:bg-sky-500 text-white font-bold px-7 py-3.5 rounded-xl text-xs sm:text-sm transition-all shadow-lg hover:shadow-xl shadow-blue-500/20 flex items-center justify-center gap-2 group active:scale-95">
                <span>View Annual Plans</span>
                <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello I want to activate Microsoft 365')) }}" target="_blank" class="w-full sm:w-auto bg-[#25d366] hover:bg-[#20bd5a] text-slate-950 font-bold px-7 py-3.5 rounded-xl text-xs sm:text-sm transition-all shadow-lg hover:shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-2 group active:scale-95">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>WhatsApp: {{ site_setting('whatsapp_number', '+880 1342-325558') }}</span>
            </a>
            <a href="tel:{{ site_setting('contact_phone_raw', '+88096490123756') }}" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold px-6 py-3.5 rounded-xl text-xs sm:text-sm border border-white/20 transition-all shadow-md flex items-center justify-center gap-2 active:scale-95">
                <i class="fa-solid fa-phone text-xs text-sky-300"></i>
                <span>{{ site_setting('contact_phone', '096490123756') }}</span>
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

        const answers = document.querySelectorAll('[id^="faq-answer-"]');
        answers.forEach(answer => {
            const id = answer.id.replace('faq-answer-', '');
            const sign = document.getElementById(`faq-sign-${id}`);
            if (allFaqsExpanded) {
                answer.classList.remove('hidden');
                if (sign) sign.innerText = '−';
            } else {
                answer.classList.add('hidden');
                if (sign) sign.innerText = '+';
            }
        });
    }

    // Dynamic Contact Form Handler
    async function handleContactSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('storefront-contact-form');
        const submitBtn = document.getElementById('contact-submit-btn');
        const btnIcon = document.getElementById('contact-btn-icon');
        const btnText = document.getElementById('contact-btn-text');
        const status = document.getElementById('contact-status');

        const name = document.getElementById('contact-name').value.trim();
        const email = document.getElementById('contact-email').value.trim();
        const phone = document.getElementById('contact-phone').value.trim();
        const message = document.getElementById('contact-message').value.trim();

        if (!name || !email || !message) return;

        // Set Loading State
        submitBtn.disabled = true;
        btnIcon.className = 'fa-solid fa-circle-notch fa-spin text-xs';
        btnText.innerText = 'Sending message...';
        status.className = 'hidden';

        try {
            const response = await fetch("{{ route('contact.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    message: message
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                status.className = 'block text-center text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 p-3.5 rounded-xl animate-in fade-in';
                status.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> ${data.message}`;
                form.reset();
            } else {
                let errorMsg = data.message || 'Something went wrong. Please try again.';
                if (data.errors) {
                    errorMsg = Object.values(data.errors).flat().join('<br>');
                }
                status.className = 'block text-center text-xs font-semibold bg-rose-50 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-800 p-3.5 rounded-xl animate-in fade-in';
                status.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-rose-600 mr-1.5"></i> ${errorMsg}`;
            }
        } catch (error) {
            status.className = 'block text-center text-xs font-semibold bg-rose-50 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-800 p-3.5 rounded-xl animate-in fade-in';
            status.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-rose-600 mr-1.5"></i> Unable to send message right now. Please reach us via WhatsApp or Phone.`;
        } finally {
            submitBtn.disabled = false;
            btnIcon.className = 'fa-regular fa-paper-plane text-xs';
            btnText.innerText = 'Send Message';
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

    // Initialize Owl Carousel for Trusted Brands
    $(document).ready(function () {
        if ($('.trusted-brands-carousel').length) {
            $('.trusted-brands-carousel').owlCarousel({
                loop: true,
                margin: 28,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 2500,
                autoplayHoverPause: true,
                smartSpeed: 700,
                responsive: {
                    0: {
                        items: 2,
                        margin: 16
                    },
                    480: {
                        items: 3,
                        margin: 20
                    },
                    640: {
                        items: 4,
                        margin: 24
                    },
                    768: {
                        items: 5,
                        margin: 28
                    },
                    1024: {
                        items: 6,
                        margin: 32
                    },
                    1280: {
                        items: 7,
                        margin: 36
                    }
                }
            });
        }
    });

</script>
@endpush
