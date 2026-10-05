<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') | {{ site_setting('site_name', 'Microsoft Office Club') }}</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ site_file_url('favicon', 'assets/img/favicon.png') }}">
    <link rel="shortcut icon" href="{{ site_file_url('favicon', 'assets/img/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Pro -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Dark Mode Init -->
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
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Segoe UI', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        @keyframes pulse-subtle {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(1.08); }
        }
        .animate-float {
            animation: float-slow 4s ease-in-out infinite;
        }
        .animate-blob {
            animation: pulse-subtle 8s ease-in-out infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#070d18] text-slate-700 dark:text-slate-300 min-h-screen flex flex-col justify-between selection:bg-[#0067b8] selection:text-white transition-colors duration-200 antialiased relative overflow-x-hidden">

    <!-- Ambient Glowing Gradient Orbs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#0067b8]/20 dark:bg-[#0067b8]/15 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-emerald-500/15 dark:bg-emerald-500/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-purple-500/15 dark:bg-purple-500/10 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-40"></div>
    </div>

    <!-- Top Navigation / Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between relative z-10">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img class="h-9 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105" src="{{ site_file_url('header_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="{{ site_setting('site_name', 'Microsoft Office Club') }}">
        </a>

        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Dark Mode Toggle Button -->
            <button onclick="toggleDarkMode()" class="w-10 h-10 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center justify-center transition-all shadow-xs cursor-pointer" title="Toggle theme">
                <i class="fa-solid fa-moon dark:hidden text-sm"></i>
                <i class="fa-solid fa-sun hidden dark:block text-sm text-amber-400"></i>
            </button>

            <!-- Home Button -->
            <a href="{{ url('/') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-200 hover:border-[#0067b8] dark:hover:border-sky-400 font-bold text-xs transition-all shadow-xs">
                <i class="fa-solid fa-house text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Home</span>
            </a>

            <!-- WhatsApp Direct Help -->
            <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello, I need assistance with Microsoft Office Club.')) }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white font-bold text-xs transition-all shadow-xs">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span class="hidden sm:inline">WhatsApp Help</span>
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12 relative z-10">
        <div class="w-full max-w-2xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400 relative z-10">
        <div class="flex items-center gap-2">
            <div class="grid grid-cols-2 gap-0.5 w-3 h-3 shrink-0 opacity-80">
                <div class="bg-[#f25022]"></div>
                <div class="bg-[#7fba00]"></div>
                <div class="bg-[#00a4ef]"></div>
                <div class="bg-[#ffb900]"></div>
            </div>
            <span>{{ site_setting('footer_copyright_text', '© 2026 Microsoft 365 Reseller Bangladesh. All rights reserved.') }}</span>
        </div>

        <div class="flex items-center gap-4 text-xs">
            <a href="{{ url('/') }}#plans" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Pricing Plans</a>
            <span>•</span>
            <a href="{{ url('/') }}#faq" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">FAQs</a>
            <span>•</span>
            <a href="mailto:{{ site_setting('contact_email', 'support@cloudsync.com.bd') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Contact Support</a>
        </div>
    </footer>

</body>
</html>
