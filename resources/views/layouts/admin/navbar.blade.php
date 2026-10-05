<header class="h-14 sm:h-16 lg:h-20 bg-white dark:bg-slate-900 border-b border-slate-200/90 dark:border-slate-800 px-3 sm:px-6 lg:px-8 flex items-center justify-between shrink-0 z-30">
    
    <!-- Left: Mobile Toggle, Mobile Brand & Desktop Breadcrumb -->
    <div class="flex items-center gap-2 sm:gap-3 lg:gap-4 min-w-0">
        <button onclick="toggleSidebar()" type="button" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-pointer shrink-0 transition-colors" aria-label="Toggle Navigation Menu">
            <i class="fa-solid fa-bars-staggered text-sm"></i>
        </button>

        <!-- Mobile Title (Visible only on < lg) -->
        <div class="lg:hidden flex items-center gap-1.5 min-w-0">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse shrink-0"></span>
            <span class="font-extrabold text-xs text-slate-900 dark:text-white tracking-tight truncate">Admin Center</span>
        </div>
        
        <!-- Desktop Breadcrumb Navigation (Visible on lg+) -->
        <nav class="hidden lg:flex items-center gap-2 text-xs sm:text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors shrink-0">
                <i class="fa-solid fa-house-chimney text-xs"></i>
                <span>Admin</span>
            </a>
            @hasSection('breadcrumb')
                @yield('breadcrumb')
            @else
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                <span class="font-bold text-slate-900 dark:text-white">Dashboard</span>
            @endif
        </nav>
    </div>

    <!-- Right: Actions (Live Site, Dark Mode, Notifications, User Dropdown) -->
    <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">

        <!-- Live Site Quick Link -->
        <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3 py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
            <span>Live Website</span>
        </a>

        <!-- System Quick Refresh & Optimize Button -->
        <form action="{{ route('admin.clear-cache') }}" method="POST" class="inline-block" onsubmit="const btn = this.querySelector('button'); const icon = this.querySelector('i'); icon.classList.add('fa-spin'); btn.disabled = true;">
            @csrf
            <button type="submit" class="w-8 h-8 sm:w-auto px-0 sm:px-3 py-0 sm:py-1.5 rounded-xl border border-slate-200/80 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-800 hover:bg-emerald-50/60 dark:hover:bg-emerald-950/40 text-slate-600 dark:text-slate-300 flex items-center justify-center gap-1.5 text-xs font-bold transition-all cursor-pointer shadow-2xs group" title="Clear Cache & Optimize System">
                <i class="fa-solid fa-arrows-rotate text-xs text-emerald-600 dark:text-emerald-400 group-hover:rotate-180 transition-transform duration-300"></i>
                <span class="hidden sm:inline">Refresh System</span>
            </button>
        </form>

        <!-- Dark / Light Mode Toggler -->
        <button onclick="toggleDarkMode()" type="button" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl text-slate-700 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center bg-transparent shrink-0" title="Toggle Theme">
            <i class="fa-solid fa-moon text-sm sm:text-base dark:hidden"></i>
            <i class="fa-solid fa-sun text-sm sm:text-base hidden dark:inline-block"></i>
        </button>

        <!-- Upgraded Notification Dropdown -->
        <!-- Upgraded Notification Dropdown -->
        @php
            $adminNotifications = \App\Models\AppNotification::where(function ($q) {
                $q->whereNull('user_id')
                  ->orWhere('target_role', 'admin')
                  ->orWhere('user_id', Auth::id());
            })->latest()->take(5)->get();

            $totalUnreadAlerts = \App\Models\AppNotification::where(function ($q) {
                $q->whereNull('user_id')
                  ->orWhere('target_role', 'admin')
                  ->orWhere('user_id', Auth::id());
            })->where('is_read', false)->count();
        @endphp
        <!-- Upgraded Notification Dropdown -->
        <div class="relative" id="notification-wrapper">
            <button onclick="toggleDropdown('notification-menu')" type="button" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center justify-center hover:scale-105 active:scale-95 transition-all relative cursor-pointer shrink-0" title="Notifications">
                <i class="fa-regular fa-bell text-xs sm:text-sm"></i>
                @if($totalUnreadAlerts > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-600 px-1 text-[9px] font-black text-white ring-2 ring-white dark:ring-slate-900">
                        {{ $totalUnreadAlerts > 9 ? '9+' : $totalUnreadAlerts }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Menu -->
            <div id="notification-menu" class="hidden absolute right-0 top-full mt-2 w-[calc(100vw-24px)] max-w-sm sm:w-96 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-0 z-50 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 animate-in fade-in slide-in-from-top-2 duration-150">
                
                <div class="p-3.5 sm:p-4 bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">System Alerts</h3>
                        @if($totalUnreadAlerts > 0)
                            <span class="text-[10px] font-bold bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full">{{ $totalUnreadAlerts }} Unread</span>
                        @else
                            <span class="text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full">All clear</span>
                        @endif
                    </div>
                </div>

                <div class="max-h-[320px] sm:max-h-[360px] overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                    @forelse($adminNotifications as $notif)
                        <a href="{{ route('admin.notifications.read-and-redirect', $notif->id) }}" class="p-3.5 flex items-start gap-3 {{ !$notif->is_read ? 'bg-amber-50/30 dark:bg-amber-950/20' : '' }} hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors block group">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 text-xs mt-0.5
                                @if($notif->color === 'emerald') bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800
                                @elseif($notif->color === 'amber') bg-amber-50 dark:bg-amber-950/60 text-amber-600 border border-amber-200 dark:border-amber-800
                                @elseif($notif->color === 'rose') bg-rose-50 dark:bg-rose-950/60 text-rose-600 border border-rose-200 dark:border-rose-800
                                @elseif($notif->color === 'purple') bg-purple-50 dark:bg-purple-950/60 text-purple-600 border border-purple-200 dark:border-purple-800
                                @else bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 border border-blue-200 dark:border-blue-800 @endif">
                                <i class="{{ $notif->icon ?: 'fa-solid fa-bell' }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <p class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 transition-colors truncate">{{ $notif->title }}</p>
                                    <span class="text-[10px] text-slate-400 shrink-0">{{ $notif->created_at->diffForHumans(null, true) }}</span>
                                </div>
                                <p class="text-[11px] text-slate-600 dark:text-slate-300 font-medium truncate mt-0.5">{{ $notif->message }}</p>
                                @if(!$notif->is_read)
                                    <span class="inline-block mt-1 text-[9px] font-black bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 px-1.5 py-0.5 rounded">Action Needed</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            <i class="fa-regular fa-bell-slash text-2xl mb-2 text-slate-300 block"></i>
                            No recent notification alerts.
                        </div>
                    @endforelse
                </div>

                <div class="p-2.5 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between px-4 text-xs">
                    <a href="{{ route('admin.notifications.index') }}" class="font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-bell text-[10px]"></i>
                        <span>Notifications</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="font-bold text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                        <span>Orders &rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin User Dropdown -->
        <div class="relative" id="user-menu-wrapper">
            <button onclick="toggleDropdown('user-menu')" type="button" class="flex items-center gap-2 p-0.5 sm:px-2 sm:py-1 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all cursor-pointer shrink-0">
                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        ADM
                    </div>
                @endif
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold leading-tight">Super Admin</p>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden sm:block ml-0.5"></i>
            </button>

            <!-- Dropdown Content -->
            <div id="user-menu" class="hidden absolute right-0 top-full mt-2 w-56 sm:w-60 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-2 z-50 animate-in fade-in slide-in-from-top-2 duration-150">
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
                        <span>Admin Profile</span>
                    </a>
                    <a href="{{ route('admin.password') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <i class="fa-solid fa-key text-xs w-4 text-slate-400"></i>
                        <span>Change Password</span>
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

<!-- Mobile Breadcrumb Sub-Bar (Positioned neatly under navbar on mobile, compact & scrollable) -->
<div class="lg:hidden bg-slate-50/95 dark:bg-slate-900/95 border-b border-slate-200/80 dark:border-slate-800/80 px-3.5 py-2 flex items-center gap-1.5 text-[11px] font-medium text-slate-600 dark:text-slate-300 overflow-x-auto whitespace-nowrap custom-scrollbar shrink-0 shadow-2xs">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1 text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 shrink-0">
        <i class="fa-solid fa-house-chimney text-[10px]"></i>
        <span>Admin</span>
    </a>
    @hasSection('breadcrumb')
        @yield('breadcrumb')
    @else
        <i class="fa-solid fa-chevron-right text-[9px] text-slate-300 dark:text-slate-600 shrink-0"></i>
        <span class="font-bold text-slate-900 dark:text-white shrink-0">Dashboard</span>
    @endif
</div>
