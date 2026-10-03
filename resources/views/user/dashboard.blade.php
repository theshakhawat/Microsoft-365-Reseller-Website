<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal | Microsoft Office Club Bangladesh</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    
    <!-- Dark Mode Initializer -->
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
                            blue: '#0067b8',
                            darkblue: '#005a9e',
                            hover: '#106ebe',
                        }
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'Plus Jakarta Sans', 'Inter', '-apple-system', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Typography & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }
        
        /* Modern Slim Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
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
    </style>
</head>
<body class="h-full text-slate-800 dark:text-slate-100 antialiased flex bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-200 overflow-hidden">

    <!-- ========================================== -->
    <!-- 1. SIDEBAR (Desktop & Mobile Drawer)       -->
    <!-- ========================================== -->
    
    <!-- Mobile Backdrop Overlay -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <!-- Sidebar Aside -->
    <aside id="main-sidebar" class="fixed lg:static top-0 bottom-0 left-0 w-64 sm:w-72 bg-white dark:bg-slate-900 border-r border-slate-200/90 dark:border-slate-800 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
        
        <!-- Sidebar Top: Brand & Navigation -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Brand Logo Header -->
            <div class="h-16 sm:h-20 px-6 flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img class="h-8 sm:h-9 w-auto object-contain" src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" alt="Microsoft Office Club" />
                </a>
                <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 dark:text-slate-400">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Menu Items -->
            <nav class="px-4 pt-4 space-y-1.5 flex-1">
                <div class="px-3 pb-2 pt-1 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Main Menu
                </div>

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 transition-colors">
                    <i class="fa-solid fa-gauge-high text-sm w-5 text-center"></i>
                    <span>Overview</span>
                </a>

                <a href="#subscriptions" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>My Subscriptions</span>
                </a>

                <a href="#cloud-storage" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-cloud text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>1 TB OneDrive</span>
                    <span class="ml-auto text-[10px] font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-md">Cloud</span>
                </a>

                <a href="#apps-suite" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-download text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Download Apps</span>
                </a>

                <div class="px-3 pb-2 pt-5 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Account & Security
                </div>

                <a href="#transactions" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-file-invoice-dollar text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Invoices & Receipts</span>
                </a>

                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-regular fa-user text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Profile Settings</span>
                </a>

                <a href="{{ route('user.password') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-key text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Change Password</span>
                </a>

                <div class="px-3 pb-2 pt-5 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Quick Links
                </div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-up-right-from-square text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Live Storefront</span>
                </a>

                <a href="https://wa.me/8801342325558" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 transition-colors">
                    <i class="fa-brands fa-whatsapp text-sm w-5 text-center"></i>
                    <span>WhatsApp Support</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: User Card -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800/80 bg-slate-50/60 dark:bg-slate-900/60">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    @if($user->photo)
                        <img src="{{ asset($user->photo) }}" class="w-9 h-9 rounded-xl object-cover shrink-0 border border-slate-200 dark:border-slate-700" alt="{{ $user->name }}" />
                    @else
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition-colors cursor-pointer" title="Sign Out">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- ========================================== -->
    <!-- 2. MAIN VIEW AREA (Navbar + Dashboard)     -->
    <!-- ========================================== -->
    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

        <!-- Top Navbar -->
        <header class="h-16 sm:h-20 bg-white dark:bg-slate-900 border-b border-slate-200/90 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between shrink-0 z-30">
            
            <!-- Left: Mobile Toggle & Breadcrumb -->
            <div class="flex items-center gap-3 sm:gap-4">
                <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <i class="fa-solid fa-bars-staggered text-base"></i>
                </button>
                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Portal Dashboard
                    </h1>
                    <p class="text-xs text-slate-400 dark:text-slate-500 hidden sm:block">
                        Manage Microsoft 365 license, cloud storage & security
                    </p>
                </div>
            </div>

            <!-- Right: Actions (Storefront, Dark Mode, Notifications, User Dropdown) -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Live Storefront Quick Link -->
                <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3 py-2 rounded-xl border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-store text-xs text-[#0067b8] dark:text-sky-400"></i>
                    <span>Storefront</span>
                </a>

                <!-- Dark / Light Mode Toggler -->
                <button onclick="toggleDarkMode()" type="button" class="p-2 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center" title="Toggle Theme">
                    <i class="fa-solid fa-moon text-base dark:hidden"></i>
                    <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
                </button>

                <!-- Notification Dropdown -->
                <div class="relative" id="notification-wrapper">
                    <button onclick="toggleDropdown('notification-menu')" type="button" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center justify-center hover:scale-105 active:scale-95 transition-all relative cursor-pointer" title="Notifications">
                        <i class="fa-regular fa-bell text-sm"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-slate-900 animate-pulse"></span>
                    </button>

                    <!-- Notifications Dropdown Menu -->
                    <div id="notification-menu" class="hidden absolute right-0 mt-2 w-80 sm:w-88 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-4 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                            <h3 class="text-xs font-bold text-slate-900 dark:text-white">Notifications</h3>
                            <span class="text-[10px] font-bold bg-sky-100 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 px-2 py-0.5 rounded-full">3 New</span>
                        </div>
                        <div class="py-2 divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                            <div class="py-2.5 flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                    <i class="fa-solid fa-shield-check"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white leading-tight">License Active</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Microsoft 365 Personal provisioned successfully.</p>
                                    <span class="text-[10px] text-slate-400 mt-1 block">Just now</span>
                                </div>
                            </div>
                            <div class="py-2.5 flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                    <i class="fa-solid fa-cloud"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white leading-tight">1 TB Cloud Storage</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">OneDrive cloud capacity allocated to your account.</p>
                                    <span class="text-[10px] text-slate-400 mt-1 block">2 hours ago</span>
                                </div>
                            </div>
                            <div class="py-2.5 flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                    <i class="fa-solid fa-envelope-circle-check"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white leading-tight">bKash Verified</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Annual subscription payment receipt ready.</p>
                                    <span class="text-[10px] text-slate-400 mt-1 block">1 day ago</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 text-center">
                            <button onclick="toggleDropdown('notification-menu')" class="text-[11px] font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                                Mark all as read
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" id="user-dropdown-wrapper">
                    <button onclick="toggleDropdown('user-dropdown-menu')" type="button" class="flex items-center gap-2.5 p-1.5 sm:px-3 sm:py-2 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-200/70 dark:hover:bg-slate-700/60 transition-all cursor-pointer">
                        @if($user->photo)
                            <img src="{{ asset($user->photo) }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg object-cover" alt="{{ $user->name }}" />
                        @else
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#0067b8] text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">{{ $user->name }}</p>
                            <p class="text-[10px] text-slate-400 leading-tight">Customer</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden sm:block"></i>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
                        
                        <!-- Header inside dropdown -->
                        <div class="p-3 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 rounded-xl mb-1">
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                            <div class="mt-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Account Active</span>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="space-y-1">
                            <a href="{{ route('user.profile') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-left">
                                <i class="fa-regular fa-user text-xs w-4 text-center text-slate-400"></i>
                                <span>Profile Information</span>
                            </a>

                            <a href="{{ route('user.password') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-left">
                                <i class="fa-solid fa-key text-xs w-4 text-center text-slate-400"></i>
                                <span>Change Password</span>
                            </a>

                            <a href="#subscriptions" onclick="toggleDropdown('user-dropdown-menu');" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fa-solid fa-shield-halved text-xs w-4 text-center text-slate-400"></i>
                                <span>My Subscriptions</span>
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="my-1.5 border-t border-slate-100 dark:border-slate-800"></div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 transition-colors text-left cursor-pointer">
                                <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </header>

        <!-- Main Dashboard Scrollable Canvas -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-6 sm:space-y-8">

            <!-- 1. Modern Welcome Hero Banner -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-[#072448] to-[#0067b8] text-white p-6 sm:p-9 shadow-lg">
                <!-- Decorative Glow Background Circles -->
                <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-sky-500/20 blur-3xl pointer-events-none"></div>
                <div class="absolute right-1/3 -bottom-16 w-64 h-64 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-sky-200 border border-white/15 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Official Microsoft CSP Provisioned</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                            Hello, {{ $user->name }}!
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl">
                            Welcome to your Microsoft 365 cloud management portal. View active licenses, download official desktop apps, and access 1 TB OneDrive storage.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('home') }}#plans" target="_blank" class="bg-white hover:bg-slate-100 text-slate-900 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                            <i class="fa-solid fa-cart-shopping text-xs text-[#0067b8]"></i>
                            <span>Order New License</span>
                        </a>
                        <a href="https://wa.me/8801342325558" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>WhatsApp Support</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. Top 3 Stat Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Stat 1: Subscriptions -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Subscriptions</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">1 License (M365 Personal)</p>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> Active & Verified
                        </span>
                    </div>
                </div>

                <!-- Stat 2: Cloud Storage -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-cloud"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cloud Storage</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">1 TB OneDrive Included</p>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-1.5 overflow-hidden">
                            <div class="bg-purple-500 h-1.5 rounded-full w-[12%]"></div>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Validity Period -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-rotate text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Validity Period</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-0.5">365 Days Remaining</p>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Auto-renew enabled</span>
                    </div>
                </div>

            </div>

            <!-- 3. Grid: Active License Suite & Profile Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (2 Cols): Active Subscription & Apps -->
                <div class="lg:col-span-2 space-y-8" id="subscriptions">
                    
                    <!-- Subscription Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-2.5 py-1 rounded-full">
                                    Official Microsoft CSP Provisioned
                                </span>
                                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mt-2">
                                    Microsoft 365 Personal Subscription
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Linked Account: <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->email }}</span>
                                </p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-xl">
                                    Annual Plan (৳6,500/yr)
                                </span>
                            </div>
                        </div>

                        <!-- Included Office Apps Grid -->
                        <div class="mt-6" id="apps-suite">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Included Apps & Services</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                                
                                <!-- Word -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#185abd] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        W
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Word</p>
                                        <p class="text-[11px] text-slate-400">Full Premium</p>
                                    </div>
                                </div>

                                <!-- Excel -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#107c41] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        X
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Excel</p>
                                        <p class="text-[11px] text-slate-400">Full Premium</p>
                                    </div>
                                </div>

                                <!-- PowerPoint -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#c43e1c] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        P
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">PowerPoint</p>
                                        <p class="text-[11px] text-slate-400">Full Premium</p>
                                    </div>
                                </div>

                                <!-- Outlook -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#0078d4] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        O
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Outlook</p>
                                        <p class="text-[11px] text-slate-400">50GB Mailbox</p>
                                    </div>
                                </div>

                                <!-- OneDrive -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3" id="cloud-storage">
                                    <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        <i class="fa-solid fa-cloud text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">OneDrive</p>
                                        <p class="text-[11px] text-slate-400">1 TB Cloud</p>
                                    </div>
                                </div>

                                <!-- Copilot AI -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-500 via-pink-500 to-amber-400 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                        <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Copilot AI</p>
                                        <p class="text-[11px] text-slate-400">Integrated</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Direct Launch Office Portal Action -->
                        <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Official Microsoft portal for installations & cloud sync:
                            </p>
                            <a href="https://portal.office.com" target="_blank" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center justify-center gap-1.5 transition-all">
                                <span>Sign In to Office.com</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Transactions & Receipts Table -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs" id="transactions">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Recent Transactions & Invoices</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">History of Microsoft 365 cloud subscription payments.</p>
                            </div>
                            <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-3 py-1 rounded-xl">
                                1 Order
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                        <th class="pb-3">Invoice ID</th>
                                        <th class="pb-3">Plan</th>
                                        <th class="pb-3">Payment Method</th>
                                        <th class="pb-3">Amount</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3 text-right">Receipt</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                    <tr>
                                        <td class="py-3.5 font-mono font-bold text-slate-900 dark:text-white">
                                            #M365-{{ date('Y') }}-{{ rand(1000, 9999) }}
                                        </td>
                                        <td class="py-3.5 font-semibold text-slate-900 dark:text-white">
                                            M365 Personal (1 Year)
                                        </td>
                                        <td class="py-3.5">
                                            <span class="inline-flex items-center gap-1 font-semibold text-pink-600 dark:text-pink-400">
                                                <i class="fa-solid fa-mobile-screen-button text-xs"></i> bKash Online
                                            </span>
                                        </td>
                                        <td class="py-3.5 font-extrabold text-slate-900 dark:text-white">
                                            ৳6,500
                                        </td>
                                        <td class="py-3.5">
                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400 font-bold text-[11px] bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Paid & Active
                                            </span>
                                        </td>
                                        <td class="py-3.5 text-right">
                                            <button onclick="alert('Receipt PDF downloaded for current billing cycle.')" class="text-[#0067b8] dark:text-sky-400 hover:underline font-bold text-xs">
                                                <i class="fa-solid fa-file-arrow-down text-xs"></i> PDF
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Right Column (1 Col): Profile, Security & Dhaka Support -->
                <div class="space-y-6">

                    <!-- Profile Information Box -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                            <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Profile Information</h3>
                            <span class="text-[10px] font-bold uppercase bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 border border-sky-100 dark:border-sky-800 px-2 py-0.5 rounded-md">
                                {{ strtoupper($user->role) }}
                            </span>
                        </div>

                        <div class="mt-4 space-y-4 text-xs">
                            <div>
                                <p class="text-slate-400 font-bold uppercase text-[10px]">Name</p>
                                <p class="text-slate-900 dark:text-white font-bold mt-0.5 text-sm">{{ $user->name }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-bold uppercase text-[10px]">Email</p>
                                <p class="text-slate-900 dark:text-white font-medium mt-0.5">{{ $user->email }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-bold uppercase text-[10px]">Phone Number</p>
                                <p class="text-slate-900 dark:text-white font-medium mt-0.5">{{ $user->phone ?? '+880 1XXXXXXXXX' }}</p>
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

                    <!-- Security & Password Box -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm shrink-0">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">Account Security</h4>
                                <p class="text-[11px] text-slate-400">Manage your portal password</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                            Keep your Microsoft Reseller account secure by setting a strong password.
                        </p>
                        <a href="{{ route('user.password') }}" class="mt-4 w-full border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-key text-xs text-amber-500"></i>
                            <span>Change Password</span>
                        </a>
                    </div>

                    <!-- Dedicated Dhaka Support Hotline -->
                    <div class="bg-gradient-to-br from-emerald-900 via-slate-900 to-slate-900 text-white rounded-3xl p-6 shadow-md border border-emerald-900/60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-white">Dedicated Support</h4>
                                <p class="text-[11px] text-emerald-300">Dhaka Desk • 24/7 Priority</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-300 mt-3">
                            Need help activating apps, installing on PC/Mac, or configuring 1 TB OneDrive?
                        </p>
                        <div class="mt-4 space-y-2">
                            <a href="https://wa.me/8801342325558" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>Message on WhatsApp</span>
                            </a>
                            <a href="tel:+8801342325558" class="w-full bg-white/10 hover:bg-white/20 text-white font-semibold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition-all">
                                <i class="fa-solid fa-phone text-xs"></i>
                                <span>Call +880 1342-325558</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- 3. MODALS (Profile & Change Password)      -->
    <!-- ========================================== -->

    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl max-w-md w-full p-6 sm:p-7 transform scale-95 transition-transform duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-sky-50 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 flex items-center justify-center">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Profile Information</h3>
                </div>
                <button onclick="closeModal('profile-modal')" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="mt-5 space-y-4 text-xs">
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Full Name</label>
                    <input type="text" value="{{ $user->name }}" readonly class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium">
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Email Address</label>
                    <input type="email" value="{{ $user->email }}" readonly class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium">
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Phone Number</label>
                    <input type="text" value="{{ $user->phone ?? '+880 1XXXXXXXXX' }}" readonly class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium">
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Account Role & Status</label>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-xl bg-sky-50 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 font-bold uppercase text-[10px]">User Portal</span>
                        <span class="px-3 py-1 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 font-bold text-[10px]">Active</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                <button onclick="closeModal('profile-modal')" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs transition-all">
                    Done
                </button>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div id="password-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl max-w-md w-full p-6 sm:p-7 transform scale-95 transition-transform duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <i class="fa-solid fa-key text-sm"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Change Password</h3>
                </div>
                <button onclick="closeModal('password-modal')" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="mt-5 space-y-4 text-xs">
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Current Password</label>
                    <input type="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium focus:ring-2 focus:ring-[#0067b8]">
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">New Password</label>
                    <input type="password" placeholder="Minimum 8 characters" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium focus:ring-2 focus:ring-[#0067b8]">
                </div>
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-1">Confirm New Password</label>
                    <input type="password" placeholder="Re-enter new password" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-200 font-medium focus:ring-2 focus:ring-[#0067b8]">
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2.5">
                <button onclick="closeModal('password-modal')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50 dark:hover:bg-slate-800">
                    Cancel
                </button>
                <button onclick="alert('Password updated successfully.'); closeModal('password-modal');" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs transition-all">
                    Update Password
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. JAVASCRIPT CONTROLLERS                  -->
    <!-- ========================================== -->
    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Generic Dropdown Toggle
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            const otherMenuId = menuId === 'user-dropdown-menu' ? 'notification-menu' : 'user-dropdown-menu';
            const otherMenu = document.getElementById(otherMenuId);
            
            if (otherMenu) otherMenu.classList.add('hidden');
            if (menu) menu.classList.toggle('hidden');
        }

        // Close dropdowns on outside click
        window.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('user-dropdown-wrapper');
            const notifWrapper = document.getElementById('notification-wrapper');
            const userMenu = document.getElementById('user-dropdown-menu');
            const notifMenu = document.getElementById('notification-menu');

            if (userWrapper && !userWrapper.contains(e.target) && userMenu) {
                userMenu.classList.add('hidden');
            }
            if (notifWrapper && !notifWrapper.contains(e.target) && notifMenu) {
                notifMenu.classList.add('hidden');
            }
        });

        // Modal Controllers
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                const content = modal.querySelector('div');
                if (content) {
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                }
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
                const content = modal.querySelector('div');
                if (content) {
                    content.classList.add('scale-95');
                    content.classList.remove('scale-100');
                }
            }
        }
    </script>
</body>
</html>
