<header class="h-16 sm:h-20 bg-white dark:bg-slate-900 border-b border-slate-200/90 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between shrink-0 z-30">
    
    <!-- Left: Mobile Toggle & Breadcrumb -->
    <div class="flex items-center gap-3 sm:gap-4">
        <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-pointer">
            <i class="fa-solid fa-bars-staggered text-base"></i>
        </button>
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs sm:text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-house-chimney text-xs"></i>
                <span>Admin</span>
            </a>
            @hasSection('breadcrumb')
                @yield('breadcrumb')
            @else
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                <span class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>Dashboard</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider bg-red-100 dark:bg-red-950/70 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/60 px-2 py-0.5 rounded-full">
                        Live Control
                    </span>
                </span>
            @endif
        </nav>
    </div>

    <!-- Right: Actions (Live Site, Dark Mode, Notifications, User Dropdown) -->
    <div class="flex items-center gap-2 sm:gap-3">

        <!-- Live Site Quick Link -->
        <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2 rounded-xl border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
            <span>Live Website</span>
        </a>

        <!-- Dark / Light Mode Toggler -->
        <button onclick="toggleDarkMode()" type="button" class="p-2.5 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center bg-transparent" title="Toggle Theme">
            <i class="fa-solid fa-moon text-base dark:hidden"></i>
            <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
        </button>

        <!-- Upgraded Notification Dropdown -->
        <div class="relative" id="notification-wrapper">
            <button onclick="toggleDropdown('notification-menu')" type="button" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center justify-center hover:scale-105 active:scale-95 transition-all relative cursor-pointer" title="Notifications">
                <i class="fa-regular fa-bell text-sm"></i>
                <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-red-500 ring-2 ring-white dark:ring-slate-900 animate-pulse"></span>
            </button>

            <!-- Dropdown Menu -->
            <div id="notification-menu" class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-0 z-50 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 animate-in fade-in slide-in-from-top-2 duration-150">
                
                <div class="p-4 bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">System Notifications</h3>
                        <span class="text-[10px] font-bold bg-red-100 dark:bg-red-950 text-red-600 dark:text-red-400 px-2 py-0.5 rounded-full">3 New</span>
                    </div>
                    <button type="button" class="text-[11px] font-semibold text-[#0067b8] dark:text-sky-400 hover:underline cursor-pointer">Mark all read</button>
                </div>

                <div class="max-h-[340px] overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                    <div class="p-3.5 flex items-start gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors">5 New Orders Pending</p>
                                <span class="text-[10px] text-slate-400 shrink-0">5m ago</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">bKash & Nagad payments awaiting CSP license provisioning approval.</p>
                            <span class="inline-block mt-1.5 text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 px-2 py-0.5 rounded-md">Action Required</span>
                        </div>
                    </div>

                    <div class="p-3.5 flex items-start gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-950/60 border border-purple-200 dark:border-purple-800 text-purple-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors">Customer Registered</p>
                                <span class="text-[10px] text-slate-400 shrink-0">1h ago</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Tanvir Ahmed signed up for Microsoft 365 Business Standard.</p>
                        </div>
                    </div>

                    <div class="p-3.5 flex items-start gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-600 flex items-center justify-center shrink-0 text-xs mt-0.5">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors">Security Auto-Backup</p>
                                <span class="text-[10px] text-slate-400 shrink-0">3h ago</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">Daily database & user credentials backup completed successfully.</p>
                        </div>
                    </div>
                </div>

                <div class="p-2.5 bg-slate-50/50 dark:bg-slate-800/30 text-center">
                    <a href="{{ route('admin.dashboard') }}#orders" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                        View All Order Inquiries &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin User Dropdown -->
        <div class="relative" id="user-menu-wrapper">
            <button onclick="toggleDropdown('user-menu')" type="button" class="flex items-center gap-2.5 p-1 sm:px-2 sm:py-1.5 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all cursor-pointer">
                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        ADM
                    </div>
                @endif
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold leading-tight">Super Admin</p>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden sm:block ml-1"></i>
            </button>

            <!-- Dropdown Content -->
            <div id="user-menu" class="hidden absolute right-0 mt-3 w-60 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
                <div class="px-3 py-2.5 border-b border-slate-100 dark:border-slate-800">
                    <p class="text-xs font-bold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-1 text-[10px] font-bold bg-purple-100 dark:bg-purple-950/80 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-md">
                        Super Administrator
                    </span>
                </div>
                
                <div class="py-1">
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <i class="fa-regular fa-user text-xs w-4 text-slate-400"></i>
                        <span>Admin Profile Settings</span>
                    </a>
                    <a href="{{ route('admin.password') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <i class="fa-solid fa-key text-xs w-4 text-slate-400"></i>
                        <span>Change Security Password</span>
                    </a>
                </div>

                <div class="pt-1 border-t border-slate-100 dark:border-slate-800">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 transition-colors cursor-pointer">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</header>
