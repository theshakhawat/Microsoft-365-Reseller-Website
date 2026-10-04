@extends('layouts.admin.admin')

@section('title', 'SMTP & Mail Configuration | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        Settings
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        SMTP Configuration
    </span>
@endsection

@section('content')
<div class="space-y-8 max-w-6xl">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0"></i>
            <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('test_success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"></i>
            <div>
                <p class="text-xs sm:text-sm font-bold">Email Sent Successfully!</p>
                <p class="text-xs mt-0.5">{{ session('test_success') }}</p>
            </div>
        </div>
    @endif

    @if(session('test_error'))
        <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-xs">
            <i class="fa-solid fa-triangle-exclamation text-lg text-rose-600 dark:text-rose-400 shrink-0 mt-0.5"></i>
            <div class="space-y-1">
                <p class="text-xs sm:text-sm font-bold">SMTP Connection Test Failed</p>
                <p class="text-xs font-mono break-all bg-white/60 dark:bg-black/30 p-2.5 rounded-xl border border-rose-200 dark:border-rose-900/60">
                    {{ session('test_error') }}
                </p>
                <p class="text-[11px] text-rose-600 dark:text-rose-400">Please verify your Host, Port, Username, Password, and Encryption settings below.</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-xs">
            <i class="fa-solid fa-circle-exclamation text-lg text-red-600 dark:text-red-400 shrink-0 mt-0.5"></i>
            <div class="text-xs sm:text-sm">
                <p class="font-bold">Please correct the following errors:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-server"></i>
                </span>
                <span>SMTP & Mail Settings</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Configure your outgoing email server dynamically from the database without touching the <code class="px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 rounded font-mono text-xs">.env</code> file.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($smtp->is_active && $smtp->mail_host)
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-xs font-bold shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Active Driver: {{ strtoupper($smtp->mail_mailer) }}</span>
                </span>
            @else
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-400 text-xs font-bold shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Configuration Incomplete</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Quick Presets Toolbar -->
    <div class="bg-gradient-to-r from-blue-50/80 via-indigo-50/50 to-slate-50/80 dark:from-slate-900 dark:via-slate-800/60 dark:to-slate-900 p-5 rounded-3xl border border-blue-100 dark:border-slate-800 shadow-xs space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 dark:text-slate-300 flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-[#0067b8] dark:text-sky-400"></i>
                <span>One-Click Server Presets</span>
            </h3>
            <span class="text-[11px] text-slate-400">Click to autofill Host, Port & Encryption</span>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2.5">
            <button type="button" onclick="applyPreset('gmail')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-brands fa-google text-red-500"></i>
                    <span>Gmail</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Port 587 (TLS)</p>
            </button>

            <button type="button" onclick="applyPreset('hostinger')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-server text-purple-500"></i>
                    <span>Hostinger</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Port 465 (SSL)</p>
            </button>

            <button type="button" onclick="applyPreset('brevo')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-paper-plane text-emerald-500"></i>
                    <span>Brevo</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Port 587 (TLS)</p>
            </button>

            <button type="button" onclick="applyPreset('mailgun')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-fire text-amber-500"></i>
                    <span>Mailgun</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Port 587 (TLS)</p>
            </button>

            <button type="button" onclick="applyPreset('sendgrid')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-paperclip text-blue-500"></i>
                    <span>SendGrid</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Port 587 (TLS)</p>
            </button>

            <button type="button" onclick="applyPreset('log')" class="p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:border-[#0067b8] dark:hover:border-sky-400 hover:shadow-md transition-all text-left group cursor-pointer">
                <p class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-[#0067b8] dark:group-hover:text-sky-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-terminal text-slate-500"></i>
                    <span>Local Log</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Testing Mode</p>
            </button>
        </div>
    </div>

    <!-- Main Grid: Configuration Form & Test Email Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Configuration Form (2 Cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 dark:text-white">Mail Server Credentials</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Fill in your SMTP host, port, authentication credentials, and sender info.</p>
                    </div>
                </div>

                <form action="{{ route('admin.smtp.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Mail Driver & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                Mail Driver (Mailer) <span class="text-red-500">*</span>
                            </label>
                            <select name="mail_mailer" id="mail_mailer" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                                <option value="smtp" {{ old('mail_mailer', $smtp->mail_mailer) === 'smtp' ? 'selected' : '' }}>SMTP (Recommended)</option>
                                <option value="sendmail" {{ old('mail_mailer', $smtp->mail_mailer) === 'sendmail' ? 'selected' : '' }}>Sendmail (Server Daemon)</option>
                                <option value="log" {{ old('mail_mailer', $smtp->mail_mailer) === 'log' ? 'selected' : '' }}>Log (Write to storage/logs/laravel.log)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                SMTP Service Status
                            </label>
                            <label class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $smtp->is_active) ? 'checked' : '' }} class="w-4 h-4 text-[#0067b8] rounded border-slate-300 focus:ring-[#0067b8]">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">Enable Database SMTP</span>
                            </label>
                        </div>
                    </div>

                    <!-- Host & Port -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                SMTP Host Server <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-network-wired absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $smtp->mail_host) }}" placeholder="e.g. smtp.gmail.com" required
                                       class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                SMTP Port <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-hashtag absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                <input type="number" name="mail_port" id="mail_port" value="{{ old('mail_port', $smtp->mail_port) }}" placeholder="587" required
                                       class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                            </div>
                        </div>
                    </div>

                    <!-- Username & Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                SMTP Username / API Key
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-user-tag absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username', $smtp->mail_username) }}" placeholder="e.g. support@yourdomain.com or apikey"
                                       class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                SMTP Password / App Secret
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-key absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                <input type="password" name="mail_password" id="mail_password" value="{{ old('mail_password', $smtp->mail_password) }}" placeholder="••••••••••••••••"
                                       class="w-full pl-9 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                                <button type="button" onclick="togglePasswordVisibility('mail_password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Encryption & Scheme -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Mail Encryption Protocol
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                                <input type="radio" name="mail_encryption" id="enc_tls" value="tls" {{ old('mail_encryption', $smtp->mail_encryption) === 'tls' ? 'checked' : '' }} class="text-[#0067b8] focus:ring-[#0067b8]">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">TLS (Port 587)</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                                <input type="radio" name="mail_encryption" id="enc_ssl" value="ssl" {{ old('mail_encryption', $smtp->mail_encryption) === 'ssl' ? 'checked' : '' }} class="text-[#0067b8] focus:ring-[#0067b8]">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">SSL (Port 465)</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                                <input type="radio" name="mail_encryption" id="enc_starttls" value="starttls" {{ old('mail_encryption', $smtp->mail_encryption) === 'starttls' ? 'checked' : '' }} class="text-[#0067b8] focus:ring-[#0067b8]">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">STARTTLS</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                                <input type="radio" name="mail_encryption" id="enc_none" value="none" {{ empty(old('mail_encryption', $smtp->mail_encryption)) ? 'checked' : '' }} class="text-[#0067b8] focus:ring-[#0067b8]">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">None (Plain)</span>
                            </label>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 dark:border-slate-800 pt-6">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[#0067b8]"></i>
                            <span>Global Sender Information</span>
                        </h3>

                        <!-- From Email & From Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                    From Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fa-solid fa-at absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                    <input type="email" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address', $smtp->mail_from_address) }}" placeholder="e.g. support@microsoftoffice.club" required
                                           class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">This email address will appear in the customer's inbox "From" header.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                    From Display Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fa-solid fa-signature absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                    <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name', $smtp->mail_from_name) }}" placeholder="e.g. Microsoft Office Club" required
                                           class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1">The friendly company or store name displayed to the recipient.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs font-extrabold shadow-lg shadow-blue-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Save & Apply SMTP Configuration</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Test Email Tool & Instructions Card (1 Col) -->
        <div class="space-y-6">
            
            <!-- Send Test Email Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-base shrink-0 shadow-xs">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Send Test Email</h3>
                        <p class="text-[11px] text-slate-400">Verify your SMTP connection instantly</p>
                    </div>
                </div>

                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Test your active SMTP configuration by sending an authentic verification message to any inbox.
                </p>

                <form action="{{ route('admin.smtp.test') }}" method="POST" class="space-y-3 pt-2">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Recipient Email Address
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            <input type="email" name="test_email" value="{{ old('test_email', Auth::user()->email) }}" placeholder="your-email@example.com" required
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Send Test Email Now</span>
                    </button>
                </form>
            </div>

            <!-- Configuration Helper Notes -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-200/90 dark:border-slate-700 p-6 space-y-3 text-xs">
                <h4 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-[#0067b8]"></i>
                    <span>Quick Configuration Guide</span>
                </h4>
                <ul class="space-y-2 text-slate-600 dark:text-slate-300 text-[11px] leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-500 mt-0.5 shrink-0"></i>
                        <span><strong>Gmail:</strong> Use an <em>App Password</em> (16 characters) from your Google Account Security page, not your regular Gmail password.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-500 mt-0.5 shrink-0"></i>
                        <span><strong>Port 587:</strong> Standard TLS submission port. Recommended for most modern mail providers.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-500 mt-0.5 shrink-0"></i>
                        <span><strong>Port 465:</strong> SMTPS (Direct SSL encryption). Common for Hostinger and cPanel servers.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-500 mt-0.5 shrink-0"></i>
                        <span><strong>Database Priority:</strong> When active, these database settings automatically override any static environment variables.</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>

<!-- Interactive JavaScript for Presets and Password Toggle -->
<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function applyPreset(type) {
        const mailer = document.getElementById('mail_mailer');
        const host = document.getElementById('mail_host');
        const port = document.getElementById('mail_port');
        const encTls = document.getElementById('enc_tls');
        const encSsl = document.getElementById('enc_ssl');
        const encNone = document.getElementById('enc_none');

        if (type === 'gmail') {
            mailer.value = 'smtp';
            host.value = 'smtp.gmail.com';
            port.value = 587;
            encTls.checked = true;
        } else if (type === 'hostinger') {
            mailer.value = 'smtp';
            host.value = 'smtp.hostinger.com';
            port.value = 465;
            encSsl.checked = true;
        } else if (type === 'brevo') {
            mailer.value = 'smtp';
            host.value = 'smtp-relay.brevo.com';
            port.value = 587;
            encTls.checked = true;
        } else if (type === 'mailgun') {
            mailer.value = 'smtp';
            host.value = 'smtp.mailgun.org';
            port.value = 587;
            encTls.checked = true;
        } else if (type === 'sendgrid') {
            mailer.value = 'smtp';
            host.value = 'smtp.sendgrid.net';
            port.value = 587;
            encTls.checked = true;
        } else if (type === 'log') {
            mailer.value = 'log';
            host.value = '127.0.0.1';
            port.value = 2525;
            encNone.checked = true;
        }
    }
</script>
@endsection

