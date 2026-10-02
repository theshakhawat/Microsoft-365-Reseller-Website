<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8fafc]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Center | Microsoft Office Club Bangladesh</title>
    
    <!-- Dark Mode Initializer -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
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
                        sans: ['Segoe UI', 'Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
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
<body class="h-full text-slate-800 dark:text-slate-100 antialiased flex flex-col bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-200">

    <!-- Top Admin Navigation Bar -->
    <header class="sticky top-0 z-40 bg-slate-900 dark:bg-slate-900/90 dark:backdrop-blur-md text-white border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Brand Logo & Admin Badge -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <img class="h-9 w-auto object-contain bg-white rounded-lg p-1" src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" alt="Microsoft Office Club" />
                    </a>
                    <span class="text-[11px] font-bold uppercase tracking-wider bg-red-950 text-red-400 border border-red-800 px-2.5 py-0.5 rounded-full flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
                        Admin Control Panel
                    </span>
                </div>

                <!-- Right Profile & Actions -->
                <div class="flex items-center gap-3">
                    <!-- Dark Mode Toggle Button -->
                    <button id="themeToggleBtn" onclick="toggleDarkMode()" type="button" aria-label="Toggle Theme" class="p-2 text-slate-300 hover:text-white dark:text-amber-400 dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center">
                        <i class="fa-solid fa-moon text-base dark:hidden"></i>
                        <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
                    </button>

                    <a href="{{ route('home') }}" class="hidden md:flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white px-3 py-2 rounded-lg hover:bg-slate-800 transition-colors">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        <span>Live Site</span>
                    </a>

                    <!-- Admin Profile Info -->
                    <div class="flex items-center gap-3 pl-3 border-l border-slate-700">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                            ADM
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-bold text-white leading-tight">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-400 leading-tight">Super Admin</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 sm:px-3 sm:py-2 text-xs font-bold text-slate-300 hover:text-red-400 hover:bg-red-950/50 rounded-xl border border-slate-700 hover:border-red-800 transition-all flex items-center gap-1.5" title="Sign Out">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Top Page Title & Quick Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Executive Dashboard
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Overview of Microsoft 365 license distribution, revenue, and active customer accounts.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#plans" target="_blank" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-xs">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>New Subscription Order</span>
                </a>
            </div>
        </div>

        <!-- 4 Stat Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            <!-- Stat 1: Total Customers -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Customers</p>
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-3">{{ $stats['total_users'] }}</p>
                <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-2">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>Registered in platform</span>
                </div>
            </div>

            <!-- Stat 2: Active Subscriptions -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Active Licenses</p>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-3">{{ $stats['active_licenses'] }}</p>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-semibold mt-2">
                    <span>Provisioned CSP seats</span>
                </div>
            </div>

            <!-- Stat 3: Monthly Revenue -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Monthly Volume</p>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base">
                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-3">৳{{ number_format($stats['monthly_revenue']) }}</p>
                <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-2">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>bKash & Nagad verified</span>
                </div>
            </div>

            <!-- Stat 4: Pending Inquiries -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pending Orders</p>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-white mt-3">{{ $stats['pending_orders'] }}</p>
                <div class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-semibold mt-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Awaiting bKash confirmation</span>
                </div>
            </div>

        </div>

        <!-- Recent Registered Users Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">Registered Accounts</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Real-time user registry from users table.</p>
                </div>
                <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-3 py-1 rounded-xl">
                    Total: {{ count($recentUsers) }} Records
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="pb-3.5">User</th>
                            <th class="pb-3.5">Contact</th>
                            <th class="pb-3.5">Role</th>
                            <th class="pb-3.5">Status</th>
                            <th class="pb-3.5">Registered</th>
                            <th class="pb-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse ($recentUsers as $u)
                            <tr>
                                <td class="py-4 font-semibold text-slate-900 dark:text-white flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[#0067b8] dark:text-sky-400 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white">{{ $u->name }}</p>
                                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-normal">{{ $u->email }}</p>
                                    </div>
                                </td>
                                <td class="py-4 text-slate-600 dark:text-slate-400 font-mono">
                                    {{ $u->phone ?? 'N/A' }}
                                </td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200 dark:bg-purple-950/60 dark:text-purple-300 dark:border-purple-800' : 'bg-sky-50 text-[#0067b8] border border-sky-100 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800' }}">
                                        {{ $u->role }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    @if ($u->status)
                                        <span class="inline-flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400 font-bold text-[11px]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-red-600 dark:text-red-400 font-bold text-[11px]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Deactivated
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-slate-500 dark:text-slate-400">
                                    {{ $u->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 text-right">
                                    <button class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline px-2 py-1 rounded">
                                        View Tenant
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500">
                                    No accounts registered yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Dark Mode Script -->
    <script>
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
</body>
</html>
