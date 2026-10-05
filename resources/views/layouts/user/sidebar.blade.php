<!-- Backdrop for Mobile -->
<div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- User Sidebar Aside -->
<aside id="main-sidebar" class="fixed lg:static top-0 bottom-0 left-0 w-64 sm:w-72 bg-white dark:bg-slate-900 border-r border-slate-200/90 dark:border-slate-800 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
    
    <!-- Sidebar Top: Brand & Navigation -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <!-- Brand Logo Header -->
        <div class="h-16 sm:h-20 px-5 sm:px-6 flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <img class="h-10 sm:h-12 w-auto max-w-[190px] object-contain transition-all" src="{{ site_file_url('header_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="{{ site_setting('site_name', 'Microsoft Office Club') }}" />
            </a>
            <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 dark:text-slate-400">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Menu Items -->
        <nav class="px-4 pt-4 space-y-1.5 flex-1">
            
            <!-- Dashboard / Overview -->
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('user.dashboard') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-gauge-high text-sm w-5 text-center {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Dashboard</span>
            </a>

            <!-- Service Management Category -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Service Management
            </div>

            <!-- My Subscription -->
            <a href="{{ route('user.subscriptions') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.subscriptions*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-shield-halved text-sm w-5 text-center {{ request()->routeIs('user.subscriptions*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>My Subscription</span>
            </a>

            <!-- Order -->
            <a href="{{ route('user.orders') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.orders*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping text-sm w-5 text-center {{ request()->routeIs('user.orders*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Order</span>
                </div>
            </a>

            <!-- Payment -->
            <a href="{{ route('user.payments') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.payments*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-credit-card text-sm w-5 text-center {{ request()->routeIs('user.payments*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Payment</span>
                </div>
            </a>

            <!-- Pricing Plans (Active Tab if eligible for purchase / upgrade) -->
            @if(Auth::user()->canAccessPlans())
            <a href="{{ route('user.plans') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.plans') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-box-archive text-sm w-5 text-center {{ request()->routeIs('user.plans') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Pricing Plans</span>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ request()->routeIs('user.plans') ? 'bg-white/20 text-white' : 'bg-blue-100 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400' }}">
                    {{ Auth::user()->hasActiveSubscription() ? 'Upgrade' : 'Active' }}
                </span>
            </a>
            @endif

            <!-- Profile Management Category -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Profile Management
            </div>

            <!-- My Profile -->
            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.profile') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-regular fa-user text-sm w-5 text-center {{ request()->routeIs('user.profile') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>My Profile</span>
            </a>

            <!-- My Notifications -->
            @php
                $userUnreadNotifsCount = \App\Models\AppNotification::where('user_id', Auth::id())->where('is_read', false)->count();
            @endphp
            <a href="{{ route('user.notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.notifications*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bell text-sm w-5 text-center {{ request()->routeIs('user.notifications*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Notifications</span>
                </div>
                @if($userUnreadNotifsCount > 0)
                    <span class="text-[10px] font-black {{ request()->routeIs('user.notifications*') ? 'bg-white text-[#0067b8]' : 'bg-blue-600 text-white' }} px-2 py-0.5 rounded-full animate-pulse">
                        {{ $userUnreadNotifsCount }}
                    </span>
                @endif
            </a>

            <!-- Change Password -->
            <a href="{{ route('user.password') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.password') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-key text-sm w-5 text-center {{ request()->routeIs('user.password') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Change Password</span>
            </a>

            <!-- Quick Links Category -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Quick Links
            </div>

            <!-- Live Storefront -->
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                <span>Live Storefront</span>
            </a>

            <!-- Support Ticket -->
            @php
                $userUnreadTickets = \App\Models\Ticket::where('user_id', Auth::id())->where('is_read_by_user', false)->count();
            @endphp
            <a href="{{ route('user.tickets') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('user.tickets*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors cursor-pointer">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset text-sm w-5 text-center {{ request()->routeIs('user.tickets*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Support Ticket</span>
                </div>
                @if($userUnreadTickets > 0)
                    <span class="text-[10px] font-black {{ request()->routeIs('user.tickets*') ? 'bg-white text-[#0067b8]' : 'bg-red-500 text-white' }} px-2 py-0.5 rounded-full animate-pulse">
                        {{ $userUnreadTickets }}
                    </span>
                @endif
            </a>

            <!-- Whatsapp Support -->
            <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello, I need assistance with Microsoft Office Club.')) }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 transition-colors">
                <i class="fa-brands fa-whatsapp text-sm w-5 text-center"></i>
                <span>Whatsapp Support</span>
            </a>

        </nav>
    </div>

    <!-- Sidebar Bottom: User Card -->
    <div class="p-4 border-t border-slate-100 dark:border-slate-800/80 bg-slate-50/60 dark:bg-slate-900/60">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" class="w-9 h-9 rounded-xl object-cover shrink-0 border border-slate-200 dark:border-slate-700" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-xl text-xs transition-colors cursor-pointer" title="Sign Out">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>

</aside>
