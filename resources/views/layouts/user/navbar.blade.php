<header class="h-16 sm:h-20 bg-white dark:bg-slate-900 border-b border-slate-200/90 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between shrink-0 z-30">
    
    <!-- Left: Mobile Toggle & Breadcrumb -->
    <div class="flex items-center gap-3 sm:gap-4">
        <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 cursor-pointer">
            <i class="fa-solid fa-bars-staggered text-base"></i>
        </button>
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs sm:text-sm font-medium">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                <i class="fa-solid fa-house-chimney text-xs"></i>
                <span>Portal</span>
            </a>
            @hasSection('breadcrumb')
                @yield('breadcrumb')
            @else
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                <span class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span>Dashboard</span>
                </span>
            @endif
        </nav>
    </div>

    <!-- Right: Actions (Live Site, Dark Mode, User Dropdown) -->
    <div class="flex items-center gap-2 sm:gap-3">

        <!-- Storefront Quick Link -->
        <a href="{{ route('home') }}" target="_blank" class="hidden md:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2 rounded-xl border border-slate-200/80 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
            <span>Live Website</span>
        </a>

        <!-- Dark / Light Mode Toggler -->
        <button onclick="toggleDarkMode()" type="button" class="p-2.5 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center bg-transparent" title="Toggle Theme">
            <i class="fa-solid fa-moon text-base dark:hidden"></i>
            <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
        </button>

        <!-- Upgraded Professional User Notification Dropdown -->
        @php
            $userId = Auth::id();
            $userNotifications = \App\Models\AppNotification::where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get();
            $totalUserUnread = \App\Models\AppNotification::where('user_id', $userId)
                ->where('is_read', false)
                ->count();
        @endphp
        <div class="relative" id="user-notification-wrapper">
            <button onclick="toggleDropdown('user-notification-menu')" type="button" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center justify-center hover:scale-105 active:scale-95 transition-all relative cursor-pointer" title="Notifications">
                <i class="fa-regular fa-bell text-sm"></i>
                @if($totalUserUnread > 0)
                    <span class="absolute top-1.5 right-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-blue-600 px-1 text-[9px] font-black text-white ring-2 ring-white dark:ring-slate-900">
                        {{ $totalUserUnread > 9 ? '9+' : $totalUserUnread }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Menu Card -->
            <div id="user-notification-menu" class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-0 z-50 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 animate-in fade-in slide-in-from-top-2 duration-150">
                
                <!-- Header -->
                <div class="p-4 bg-slate-50/70 dark:bg-slate-800/40 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Account & Support Alerts</h3>
                        @if($totalUserUnread > 0)
                            <span class="text-[10px] font-bold bg-blue-100 dark:bg-blue-950 text-[#0067b8] dark:text-sky-400 px-2 py-0.5 rounded-full">{{ $totalUserUnread }} New</span>
                        @else
                            <span class="text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full">All Caught Up</span>
                        @endif
                    </div>
                </div>

                <!-- Notification Feed -->
                <div class="max-h-[360px] overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                    @forelse($userNotifications as $notif)
                        <a href="{{ route('user.notifications.read-and-redirect', $notif->id) }}" class="p-3.5 flex items-start gap-3 {{ !$notif->is_read ? 'bg-blue-50/30 dark:bg-blue-950/20' : '' }} hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors block group">
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
                                    <span class="inline-block mt-1 text-[9px] font-black bg-blue-100 text-[#0067b8] dark:bg-blue-950 dark:text-sky-300 px-1.5 py-0.5 rounded">NEW</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">
                            <i class="fa-regular fa-bell-slash text-2xl mb-2 text-slate-300 block"></i>
                            No notifications found. All caught up!
                        </div>
                    @endforelse
                </div>

                <!-- Footer Quick Links -->
                <div class="p-2.5 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between text-xs px-4">
                    <a href="{{ route('user.notifications') }}" class="font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-bell text-[10px]"></i>
                        <span>All Notifications Center</span>
                    </a>
                    <a href="{{ route('user.orders') }}" class="font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white">
                        <span>Orders &rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Pill & Dropdown -->
        <div class="relative" id="user-menu-wrapper">
            <button onclick="toggleDropdown('user-menu')" type="button" class="flex items-center gap-2.5 p-1 sm:pr-3 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-colors cursor-pointer">
                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 hidden sm:block">{{ Auth::user()->name }}</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 hidden sm:block"></i>
            </button>

            <div id="user-menu" class="hidden absolute right-0 mt-3 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200/90 dark:border-slate-800 py-1.5 z-50 divide-y divide-slate-100 dark:divide-slate-800">
                <div class="px-4 py-2">
                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('user.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                        <i class="fa-regular fa-user text-xs w-4 text-center text-slate-400"></i>
                        <span>Profile Settings</span>
                    </a>
                    <a href="{{ route('user.password') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-key text-xs w-4 text-center text-slate-400"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="{{ route('user.tickets') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                        <i class="fa-solid fa-headset text-xs w-4 text-center text-[#0067b8]"></i>
                        <span>Support Tickets</span>
                    </a>
                </div>
                <div class="py-1">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 text-left cursor-pointer">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</header>
