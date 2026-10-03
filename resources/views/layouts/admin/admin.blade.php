<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Control Center | Microsoft Office Club Bangladesh')</title>
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

    <!-- 1. ADMIN SIDEBAR (Reusable Component) -->
    @include('layouts.admin.sidebar')

    <!-- 2. MAIN VIEW AREA -->
    <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">

        <!-- Reusable Top Navbar -->
        @include('layouts.admin.navbar')

        <!-- Dynamic Page Content -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
            @yield('content')
        </main>

    </div>

    <!-- ==================================================== -->
    <!-- REUSABLE CUSTOM DELETE CONFIRMATION MODAL            -->
    <!-- ==================================================== -->
    <div id="custom-delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
        
        <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-6 sm:p-7 text-center transform scale-95 transition-all duration-200" id="custom-delete-modal-card">
            
            <!-- Warning Icon -->
            <div class="w-16 h-16 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 flex items-center justify-center text-2xl mx-auto mb-4 shadow-xs">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <!-- Title & Message -->
            <h3 class="text-lg font-black text-slate-900 dark:text-white" id="delete-modal-title">
                Confirm Deletion
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed" id="delete-modal-message">
                Are you sure you want to permanently delete this item? This action cannot be reversed.
            </p>

            <!-- Action Buttons -->
            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-3 px-4 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    Cancel
                </button>

                <form id="delete-modal-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 px-4 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition-colors shadow-md shadow-red-600/25 cursor-pointer flex items-center justify-center gap-1.5 active:scale-95">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                        <span>Yes, Delete</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Dropdown & Modal Interaction Global Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            } else {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            }
        }

        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            const otherMenuId = menuId === 'user-menu' ? 'notification-menu' : 'user-menu';
            const otherMenu = document.getElementById(otherMenuId);
            
            if (otherMenu) otherMenu.classList.add('hidden');
            if (menu) menu.classList.toggle('hidden');
        }

        // Custom Delete Confirmation Modal Handlers
        function openDeleteModal(actionUrl, itemName = 'this item', customMessage = null) {
            const modal = document.getElementById('custom-delete-modal');
            const card = document.getElementById('custom-delete-modal-card');
            const form = document.getElementById('delete-modal-form');
            const title = document.getElementById('delete-modal-title');
            const message = document.getElementById('delete-modal-message');

            form.action = actionUrl;
            title.innerText = 'Delete ' + itemName + '?';
            if (customMessage) {
                message.innerText = customMessage;
            } else {
                message.innerText = 'Are you sure you want to permanently delete ' + itemName + '? This action cannot be undone.';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('custom-delete-modal');
            const card = document.getElementById('custom-delete-modal-card');
            
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        // Close modal when clicking on backdrop
        document.getElementById('custom-delete-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('user-menu-wrapper');
            const notifWrapper = document.getElementById('notification-wrapper');
            const userMenu = document.getElementById('user-menu');
            const notifMenu = document.getElementById('notification-menu');

            if (userWrapper && !userWrapper.contains(e.target) && userMenu) {
                userMenu.classList.add('hidden');
            }
            if (notifWrapper && !notifWrapper.contains(e.target) && notifMenu) {
                notifMenu.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
