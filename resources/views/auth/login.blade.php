<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Microsoft Office Club Bangladesh</title>

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
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="h-full text-slate-800 dark:text-slate-100 antialiased flex flex-col justify-between bg-gradient-to-b from-[#f8fafc] via-[#f1f5f9] to-[#e2e8f0]/40 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen transition-colors duration-200">

    <!-- Top Simplified Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 transition-transform hover:scale-[1.02]">
            <img class="h-9 sm:h-10 w-auto object-contain" src="{{ asset('assets/img/Microsoft Office Club Logo.png') }}" alt="Microsoft Office Club Bangladesh" />
        </a>
        <div class="flex items-center gap-4">
            <button onclick="toggleDarkMode()" type="button" class="p-2 text-slate-700 dark:text-amber-400 hover:text-[#0067b8] dark:hover:text-amber-300 transition-colors focus:outline-none cursor-pointer flex items-center justify-center" title="Toggle Theme">
                <i class="fa-solid fa-moon text-base dark:hidden"></i>
                <i class="fa-solid fa-sun text-base hidden dark:inline-block"></i>
            </button>
            <a href="{{ route('home') }}" class="text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back to website</span>
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">

            <!-- Card Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-7 sm:p-9">

                <!-- Header -->
                <div class="mb-7">
                    <div class="inline-flex items-center gap-2 bg-sky-50 dark:bg-sky-950/60 border border-sky-100 dark:border-sky-800 px-3 py-1 rounded-full text-xs font-bold text-[#0067b8] dark:text-sky-400 mb-3">
                        <i class="fa-solid fa-shield-halved text-[11px]"></i>
                        <span>Secure Account Access</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Welcome back
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Sign in to manage your Microsoft 365 cloud licenses.
                    </p>
                </div>

                <!-- Session Alert -->
                @if (session('status'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-xs font-semibold text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-sm"></i>
                    <span>{{ session('status') }}</span>
                </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-xs font-semibold text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-500 dark:text-red-400 text-xs"></i>
                        <span>{{ $error }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="name@domain.com" class="w-full pl-10 pr-4 py-3 bg-[#fbfbfc] dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-sky-500/10 transition-all" />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                Password
                            </label>
                            <a href="#" class="text-[11px] font-semibold text-[#0067b8] dark:text-sky-400 hover:underline">
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full pl-10 pr-10 py-3 bg-[#fbfbfc] dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-[#0067b8] dark:focus:border-sky-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-sky-500/10 transition-all" />
                            <button type="button" onclick="togglePasswordVisibility('password', 'toggle-pass-icon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 focus:outline-none text-xs cursor-pointer">
                                <i class="fa-regular fa-eye" id="toggle-pass-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#0067b8] focus:ring-[#0067b8] transition-colors" />
                            <span class="text-xs text-slate-600 dark:text-slate-400 font-medium">Keep me signed in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#0067b8] hover:bg-[#005a9e] dark:bg-sky-600 dark:hover:bg-sky-500 text-white font-bold py-3.5 px-4 rounded-xl text-sm transition-all shadow-md hover:shadow-lg active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer">
                            <span>Sign In</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </form>

                <!-- Footer Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white dark:bg-slate-900 px-3 text-slate-400 dark:text-slate-500 font-semibold tracking-wider text-[10px]">
                            New to Microsoft Club?
                        </span>
                    </div>
                </div>

                <!-- Link to Register -->
                <a href="{{ route('register') }}" class="w-full block text-center py-3 px-4 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700/60 text-slate-800 dark:text-slate-200 font-bold rounded-xl text-xs sm:text-sm transition-all">
                    Create an Account
                </a>

            </div>

        </div>
    </main>

    <!-- Bottom Copyright -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-5 text-center text-xs text-slate-500 dark:text-slate-500">
        <p>© 2026 Microsoft Office Club Bangladesh. All rights reserved.</p>
    </footer>

    <script>
        function toggleDarkMode() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        function togglePasswordVisibility(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-regular fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fa-regular fa-eye';
            }
        }
    </script>
</body>
</html>
