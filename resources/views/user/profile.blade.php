<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings | Microsoft Office Club Bangladesh</title>
    
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

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-gauge-high text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Overview</span>
                </a>

                <a href="{{ route('user.dashboard') }}#subscriptions" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>My Subscriptions</span>
                </a>

                <a href="{{ route('user.dashboard') }}#cloud-storage" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-cloud text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>1 TB OneDrive</span>
                    <span class="ml-auto text-[10px] font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-md">Cloud</span>
                </a>

                <a href="{{ route('user.dashboard') }}#apps-suite" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-download text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Download Apps</span>
                </a>

                <div class="px-3 pb-2 pt-5 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Account & Security
                </div>

                <a href="{{ route('user.dashboard') }}#transactions" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-file-invoice-dollar text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                    <span>Invoices & Receipts</span>
                </a>

                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 transition-colors">
                    <i class="fa-regular fa-user text-sm w-5 text-center"></i>
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
    <!-- 2. MAIN VIEW AREA (Navbar + Profile Content)-->
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
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <a href="{{ route('user.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
                        <span>/</span>
                        <span class="text-slate-600 dark:text-slate-300 font-semibold">Profile Settings</span>
                    </div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Profile Information
                    </h1>
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
                        <div class="p-3 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 rounded-xl mb-1">
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                        </div>

                        <div class="space-y-1">
                            <a href="{{ route('user.profile') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-300">
                                <i class="fa-regular fa-user text-xs w-4 text-center"></i>
                                <span>Profile Information</span>
                            </a>

                            <a href="{{ route('user.password') }}" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fa-solid fa-key text-xs w-4 text-center text-slate-400"></i>
                                <span>Change Password</span>
                            </a>

                            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fa-solid fa-gauge-high text-xs w-4 text-center text-slate-400"></i>
                                <span>Dashboard Overview</span>
                            </a>
                        </div>

                        <div class="my-1.5 border-t border-slate-100 dark:border-slate-800"></div>

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

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-6 sm:space-y-8">

            <!-- Flash Success Alert -->
            @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            @endif

            <!-- Errors Alert -->
            @if ($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs sm:text-sm space-y-1 shadow-xs">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-base text-red-600 dark:text-red-400"></i>
                    <span>Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Main Form Card -->
            <div class="max-w-4xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-9 shadow-xs">
                
                <div class="pb-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Personal Details</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update your account name, contact number, and profile avatar.</p>
                    </div>
                    <span class="text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-3 py-1 rounded-full self-start sm:self-auto">
                        Status: Active Account
                    </span>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-8">
                    @csrf

                    <!-- Profile Photo Upload with Live Preview -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4">
                            Profile Photo
                        </label>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                            
                            <!-- Image Preview Container -->
                            <div class="relative group">
                                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center overflow-hidden shadow-xs">
                                    <img id="photo-preview" 
                                         src="{{ $user->photo ? asset($user->photo) : '' }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-full h-full object-cover {{ $user->photo ? '' : 'hidden' }}" />
                                    
                                    <div id="photo-placeholder" class="text-center p-2 {{ $user->photo ? 'hidden' : '' }}">
                                        <div class="w-12 h-12 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 mx-auto flex items-center justify-center text-xl font-bold mb-1">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-400">No Photo</span>
                                    </div>
                                </div>

                                <label for="photo-input" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-[#0067b8] hover:bg-[#005a9e] text-white flex items-center justify-center shadow-md cursor-pointer transition-transform hover:scale-110 active:scale-95" title="Choose Photo">
                                    <i class="fa-solid fa-camera text-xs"></i>
                                </label>
                            </div>

                            <!-- Photo Upload Info & Actions -->
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-3">
                                    <label for="photo-input" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 transition-colors cursor-pointer inline-flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-up-from-bracket text-xs"></i>
                                        <span>Upload New Photo</span>
                                    </label>
                                    <button type="button" onclick="clearPreview()" id="clear-photo-btn" class="hidden text-xs font-semibold text-red-500 hover:underline">
                                        Remove Selected
                                    </button>
                                </div>
                                <input type="file" id="photo-input" name="photo" accept="image/*" onchange="previewProfilePic(event)" class="hidden" />
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">
                                    Supported formats: PNG, JPG, JPEG, WEBP. Maximum file size: 2MB.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-user text-xs"></i>
                                </span>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                Phone Number (bKash / Contact)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </span>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1XXXXXXXXX"
                                       class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Email Address (Read-Only) -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                Email Address <span class="text-slate-400 font-normal">(Linked Microsoft Account ID)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-envelope text-xs"></i>
                                </span>
                                <input type="email" id="email" value="{{ $user->email }}" readonly
                                       class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium cursor-not-allowed">
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">To change your primary email, contact customer support.</p>
                        </div>

                        <!-- Account Role & Registration Date -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                Account Role & Registration
                            </label>
                            <div class="p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-bold uppercase text-[#0067b8] dark:text-sky-400 bg-sky-100 dark:bg-sky-950 px-2.5 py-0.5 rounded-md">
                                    {{ $user->role }}
                                </span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    Joined {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Actions -->
                    <div class="border-t border-slate-100 dark:border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('user.password') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-key text-xs"></i>
                            <span>Want to change your account password instead?</span>
                        </a>

                        <button type="submit" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-8 py-3 rounded-xl text-xs sm:text-sm transition-all shadow-md active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>

                </form>

            </div>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- 3. JAVASCRIPT CONTROLLERS                  -->
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
            if (menu) menu.classList.toggle('hidden');
        }

        // Close dropdowns on outside click
        window.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('user-dropdown-wrapper');
            const userMenu = document.getElementById('user-dropdown-menu');

            if (userWrapper && !userWrapper.contains(e.target) && userMenu) {
                userMenu.classList.add('hidden');
            }
        });

        // Live Profile Image Preview Controller
        function previewProfilePic(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photo-preview');
                    const placeholder = document.getElementById('photo-placeholder');
                    const clearBtn = document.getElementById('clear-photo-btn');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                    if (clearBtn) clearBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function clearPreview() {
            const input = document.getElementById('photo-input');
            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-placeholder');
            const clearBtn = document.getElementById('clear-photo-btn');
            
            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            if (placeholder) placeholder.classList.remove('hidden');
            if (clearBtn) clearBtn.classList.add('hidden');
        }
    </script>
</body>
</html>
