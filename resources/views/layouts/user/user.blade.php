<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Portal | Microsoft Office Club Bangladesh')</title>
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
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(203, 213, 225, 0.8); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.9); }
        .dark ::-webkit-scrollbar-thumb { background: rgba(51, 65, 85, 0.7); }
        .dark ::-webkit-scrollbar-thumb:hover { background: rgba(71, 85, 105, 0.9); }
    </style>
    @stack('styles')
</head>
<body class="h-full text-slate-800 dark:text-slate-100 antialiased flex bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-200 overflow-hidden">

    <!-- 1. USER SIDEBAR (Reusable Component) -->
    @include('layouts.user.sidebar')

    <!-- 2. MAIN VIEW AREA -->
    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

        <!-- Reusable Top Navbar -->
        @include('layouts.user.navbar')

        <!-- Dynamic Page Content -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
            @yield('content')
        </main>

    </div>

    <!-- ==================================================== -->
    <!-- REUSABLE CUSTOM ACTION CONFIRMATION MODAL (User Portal) -->
    <!-- ==================================================== -->
    <div id="user-custom-action-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-6 sm:p-7 text-center transform scale-95 transition-all duration-200" id="user-custom-action-modal-card">
            
            <!-- Dynamic Icon Container -->
            <div id="user-action-modal-icon-wrapper" class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-2xl mx-auto mb-4 shadow-xs">
                <i id="user-action-modal-icon" class="fa-solid fa-circle-question"></i>
            </div>

            <!-- Title & Message -->
            <h3 class="text-lg font-black text-slate-900 dark:text-white" id="user-action-modal-title">
                Confirm Action
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed" id="user-action-modal-message">
                Are you sure you want to proceed?
            </p>

            <!-- Action Buttons -->
            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" onclick="closeUserActionModal()" class="flex-1 py-3 px-4 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    Cancel
                </button>

                <form id="user-action-modal-form" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="_method" id="user-action-modal-method" value="POST">
                    <button type="submit" id="user-action-modal-btn" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-[#0067b8] hover:bg-[#005a9e] transition-colors shadow-md shadow-[#0067b8]/25 cursor-pointer flex items-center justify-center gap-1.5 active:scale-95">
                        <span id="user-action-modal-btn-text">Confirm</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Toggle Sidebar Script for Mobile & Global Modal -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        function openUserActionModal(options) {
            const modal = document.getElementById('user-custom-action-modal');
            const card = document.getElementById('user-custom-action-modal-card');
            const form = document.getElementById('user-action-modal-form');
            const title = document.getElementById('user-action-modal-title');
            const message = document.getElementById('user-action-modal-message');
            const iconWrapper = document.getElementById('user-action-modal-icon-wrapper');
            const icon = document.getElementById('user-action-modal-icon');
            const btn = document.getElementById('user-action-modal-btn');
            const btnText = document.getElementById('user-action-modal-btn-text');
            const methodInput = document.getElementById('user-action-modal-method');

            form.action = options.actionUrl;
            title.innerText = options.title || 'Confirm Action';
            message.innerText = options.message || 'Are you sure you want to proceed?';
            btnText.innerText = options.btnText || 'Confirm';
            methodInput.value = options.method || 'POST';

            const type = options.type || 'blue';
            if (type === 'rose') {
                iconWrapper.className = 'w-16 h-16 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 flex items-center justify-center text-2xl mx-auto mb-4 shadow-xs';
                icon.className = options.icon || 'fa-solid fa-circle-xmark';
                btn.className = 'w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-md shadow-rose-600/25 cursor-pointer flex items-center justify-center gap-1.5 active:scale-95';
            } else {
                iconWrapper.className = 'w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-2xl mx-auto mb-4 shadow-xs';
                icon.className = options.icon || 'fa-solid fa-circle-question';
                btn.className = 'w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-[#0067b8] hover:bg-[#005a9e] transition-colors shadow-md shadow-[#0067b8]/25 cursor-pointer flex items-center justify-center gap-1.5 active:scale-95';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeUserActionModal() {
            const modal = document.getElementById('user-custom-action-modal');
            const card = document.getElementById('user-custom-action-modal-card');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            const otherMenuId = menuId === 'user-menu' ? 'user-notification-menu' : 'user-menu';
            const otherMenu = document.getElementById(otherMenuId);
            
            if (otherMenu) otherMenu.classList.add('hidden');
            if (menu) menu.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('user-menu-wrapper');
            const notifWrapper = document.getElementById('user-notification-wrapper');
            const userMenu = document.getElementById('user-menu');
            const notifMenu = document.getElementById('user-notification-menu');

            if (userWrapper && !userWrapper.contains(e.target) && userMenu) {
                userMenu.classList.add('hidden');
            }
            if (notifWrapper && !notifWrapper.contains(e.target) && notifMenu) {
                notifMenu.classList.add('hidden');
            }
        });
    </script>

    <!-- Realtime Push Notifications Partial -->
    @include('partials.realtime-notifications')

    @stack('scripts')
</body>
</html>
