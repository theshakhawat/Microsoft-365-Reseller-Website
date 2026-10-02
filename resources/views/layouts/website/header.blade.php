<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Microsoft 365 Reseller') . ' | Official Subscriptions & Cloud Licensing Bangladesh')</title>
    <meta name="description" content="Official Microsoft 365, Office Apps, and Copilot AI subscription reseller in Bangladesh. Instant BDT payment via bKash/Nagad, automated license provisioning, and 24/7 Dhaka support.">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        ms: {
                            red: '#f25022',
                            green: '#7fba00',
                            blue: '#00a4ef',
                            yellow: '#ffb900',
                            darkblue: '#0078d4',
                            hoverblue: '#106ebe',
                            deepnavy: '#0b192c',
                            darkbg: '#0a0f1d',
                            cardbg: '#111827',
                            border: '#1f293d',
                        },
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            500: '#0078d4',
                            600: '#0067b8',
                            700: '#005da6',
                            800: '#0b2744',
                            900: '#071629',
                            950: '#040d1a',
                        },
                        accent: {
                            DEFAULT: '#00a4ef',
                            dark: '#0078d4',
                            glow: '#38bdf8'
                        }
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'Plus Jakarta Sans', 'Inter', '-apple-system', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'ms-soft': '0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04)',
                        'ms-glow': '0 0 35px -5px rgba(0, 164, 239, 0.35)',
                        'ms-card': '0 10px 30px -10px rgba(0, 120, 212, 0.15)',
                    }
                }
            }
        }
    </script>

    <!-- Typography & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }

        /* Modern Slim Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(203, 213, 225, 0.8);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.9);
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.7);
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(71, 85, 105, 0.9);
        }

        .nav-link-item {
            position: relative;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            transition: color 0.2s ease;
        }

        .nav-link-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #0067b8;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 9999px;
        }

        .dark .nav-link-item::after {
            background-color: #38bdf8;
        }

        .nav-link-item:hover::after,
        .nav-link-item.active::after {
            transform: scaleX(1);
        }
    </style>

    @stack('css')
</head>
<body class="bg-[#f8fafc] dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-brand-500 selection:text-white min-h-screen flex flex-col transition-colors duration-200">

    <!-- ========================================== -->
    <!-- TOP ANNOUNCEMENT RIBBON (Microsoft Style)  -->
    <!-- ========================================== -->
    <div class="bg-gradient-to-r from-slate-900 via-brand-950 to-slate-900 text-white text-xs border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2 text-slate-300">
                <!-- Microsoft 4-Color Squares Mini Icon -->
                <div class="grid grid-cols-2 gap-0.5 w-3.5 h-3.5 shrink-0">
                    <div class="bg-[#f25022] rounded-[1px]"></div>
                    <div class="bg-[#7fba00] rounded-[1px]"></div>
                    <div class="bg-[#00a4ef] rounded-[1px]"></div>
                    <div class="bg-[#ffb900] rounded-[1px]"></div>
                </div>
                <span class="font-medium text-[11px] sm:text-xs">
                    <strong class="text-white">Official Microsoft Reseller</strong> • Purchase plan via bKash, Nagad & Cards
                </span>
            </div>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="https://wa.me/8801342325558" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-semibold flex items-center gap-1 transition-colors">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>WhatsApp Helpline: +880 1342-325558</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- COMPONENT: NAVBAR (Microsoft Fluent Style) -->
    <!-- ========================================== -->
    <header id="navbar" class="sticky top-0 z-50 transition-all duration-300 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-2">

                <!-- Brand Logo (Left) -->
                <div class="flex items-center shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <img class="h-10 sm:h-12 w-auto object-contain" src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" alt="Microsoft Office Club Bangladesh" />
                    </a>
                </div>

                <!-- Desktop Navigation Links (Centered with bottom border hover bar) -->
                <nav class="hidden lg:flex items-center justify-center gap-7 text-[13px] font-semibold mx-auto">
                    <a href="#copilot-showcase" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">Copilot AI</a>
                    <a href="#included-apps" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">Included Apps</a>
                    <a href="#plans" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">Plans & Pricing</a>
                    <a href="#ai-features" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">AI Features</a>
                    <a href="#how-it-works" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">How It Works</a>
                    <a href="#faq" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">FAQ</a>
                    <a href="#contact-support" class="nav-link-item text-slate-700 hover:text-[#0067b8] dark:text-slate-300 dark:hover:text-[#38bdf8]">Contact</a>
                </nav>

                <!-- Desktop Action Links (Right) & Theme Toggle -->
                <div class="hidden lg:flex items-center gap-5 text-[13px] font-semibold shrink-0">
                    
                    <!-- Dark Mode Toggle Button (Desktop) -->
                    <button id="theme-toggle" type="button" onclick="toggleDarkMode()" class="p-2 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center" title="Toggle Theme">
                        <i class="fa-solid fa-moon text-base dark:hidden"></i>
                        <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
                    </button>

                    @auth
                    @php
                    $dashboardRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="nav-link-item flex items-center gap-1.5 font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400">
                        <i class="fa-solid fa-gauge-high text-xs text-[#0067b8] dark:text-sky-400"></i>
                        <span>Dashboard</span>
                        @if(auth()->user()->role === 'admin')
                        <span class="bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-400 text-[9px] font-extrabold px-1.5 py-0.5 rounded uppercase">Admin</span>
                        @endif
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="nav-link-item flex items-center gap-1.5 text-slate-700 hover:text-[#0067b8] dark:text-slate-200 dark:hover:text-sky-400 font-semibold">
                        <i class="fa-regular fa-user text-xs text-slate-500 dark:text-slate-400"></i>
                        <span>Sign In</span>
                    </a>
                    <a href="{{ route('register') }}" class="nav-link-item flex items-center gap-1.5 font-bold text-slate-900 hover:text-[#0067b8] dark:text-white dark:hover:text-sky-400">
                        <span>Sign Up</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Toggle & Theme Toggle -->
                <div class="flex lg:hidden items-center gap-2">
                    <!-- Dark Mode Toggle Button (Mobile) -->
                    <button type="button" onclick="toggleDarkMode()" class="p-2 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] transition-colors focus:outline-none cursor-pointer flex items-center justify-center" title="Toggle Theme">
                        <i class="fa-solid fa-moon text-base dark:hidden"></i>
                        <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
                    </button>

                    @auth
                    @php
                    $dashboardRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="text-xs font-bold text-slate-900 dark:text-white hover:text-[#0067b8] flex items-center gap-1">
                        <i class="fa-solid fa-gauge-high text-xs text-[#0067b8] dark:text-sky-400"></i>
                        <span>Dashboard</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center gap-1">
                        <i class="fa-regular fa-user text-xs"></i>
                        <span>Sign In</span>
                    </a>
                    @endauth
                    <button id="mobile-menu-btn" type="button" class="p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none min-w-[38px] min-h-[38px] flex items-center justify-center border border-slate-200 dark:border-slate-700" aria-label="Toggle Menu">
                        <i class="fa-solid fa-bars text-lg" id="menu-icon"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Off-Canvas Slide Drawer (Placed outside header for absolute top level z-index) -->
    <!-- Backdrop Overlay -->
    <div id="mobile-menu-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[9998] opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden"></div>

    <!-- Off-canvas Sidebar Panel -->
    <aside id="mobile-sidebar" class="fixed top-0 right-0 bottom-0 w-[285px] sm:w-[320px] bg-white dark:bg-slate-900 z-[9999] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between lg:hidden border-l border-slate-200 dark:border-slate-800" aria-label="Mobile Navigation">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/80">
            <img class="h-8 w-auto object-contain" src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" alt="Microsoft Office Club" />
            <button id="mobile-sidebar-close" type="button" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center transition-colors focus:outline-none" aria-label="Close Menu">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Links (with smooth auto-close) -->
        <nav class="p-4 space-y-1.5 overflow-y-auto flex-1 custom-scrollbar">
            @auth
            @php
            $dashboardRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
            @endphp
            <a href="{{ $dashboardRoute }}" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold text-white bg-[#0067b8] hover:bg-[#005a9e] transition-colors mb-3">
                <i class="fa-solid fa-gauge-high text-xs w-4 text-center"></i>
                <span>Go to {{ auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard' }}</span>
            </a>
            @endauth

            <a href="#copilot-showcase" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-wand-magic-sparkles text-purple-600 text-xs w-4 text-center"></i>
                <span>Copilot AI</span>
            </a>
            <a href="#included-apps" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-cubes text-[#0067b8] text-xs w-4 text-center"></i>
                <span>Included Apps</span>
            </a>
            <a href="#plans" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold text-[#0067b8] dark:text-sky-400 bg-sky-50/70 dark:bg-sky-950/40 hover:bg-sky-100 dark:hover:bg-sky-900/50 transition-colors">
                <i class="fa-solid fa-tags text-[#0067b8] dark:text-sky-400 text-xs w-4 text-center"></i>
                <span>Plans & Pricing</span>
            </a>
            <a href="#ai-features" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-brain text-indigo-600 text-xs w-4 text-center"></i>
                <span>AI Features</span>
            </a>
            <a href="#how-it-works" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-list-check text-emerald-600 text-xs w-4 text-center"></i>
                <span>How It Works</span>
            </a>
            <a href="#faq" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-circle-question text-sky-600 text-xs w-4 text-center"></i>
                <span>FAQ</span>
            </a>
            <a href="#contact-support" class="mobile-nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-headset text-amber-600 text-xs w-4 text-center"></i>
                <span>Contact Support</span>
            </a>
        </nav>

        <!-- Sidebar Footer Auth Buttons -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 space-y-2 bg-slate-50/80 dark:bg-slate-950/80">
            @auth
            @php
            $dashboardRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
            @endphp
            <a href="{{ $dashboardRoute }}" class="mobile-nav-link w-full text-center py-2.5 font-bold bg-[#0067b8] text-white rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-xs">
                <i class="fa-solid fa-gauge-high text-xs"></i>
                <span>Dashboard</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full text-center py-2.5 font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-950/50 hover:text-red-600 dark:hover:text-red-400 text-slate-700 dark:text-slate-200 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-xs cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    <span>Logout</span>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="mobile-nav-link w-full text-center py-2.5 font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-xs">
                <i class="fa-regular fa-user text-xs"></i>
                <span>Sign In</span>
            </a>
            <a href="{{ route('register') }}" class="mobile-nav-link w-full text-center py-2.5 font-bold bg-[#0067b8] hover:bg-[#005a9e] text-white rounded-xl text-sm flex items-center justify-center gap-2 transition-all shadow-xs">
                <span>Sign Up</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
            @endauth
        </div>
    </aside>
