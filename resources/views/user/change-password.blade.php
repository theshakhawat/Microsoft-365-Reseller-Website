@extends('layouts.user.user')

@section('title', 'Change Password - Microsoft Office Club')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ route('user.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <span>/</span>
        <span class="text-slate-600 dark:text-slate-300 font-semibold">Security</span>
    </div>
    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
        Change Password
    </h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Flash Success Alert -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    @endif

    <!-- Errors Alert -->
    @if ($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs sm:text-sm space-y-1 shadow-xs">
        <div class="flex items-center gap-2 font-bold mb-1">
            <i class="fa-solid fa-circle-exclamation text-base text-red-600 dark:text-red-400"></i>
            <span>Could not update password:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700 dark:text-red-300">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Change Password Form Card -->
    <div class="max-w-2xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-9 shadow-xs">
        
        <div class="pb-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Security Credentials</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Ensure your account uses a strong, minimum 8-character password.</p>
            </div>
        </div>

        <form action="{{ route('user.password.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-key text-xs"></i>
                    </span>
                    <input type="password" id="current_password" name="current_password" required placeholder="Enter current password"
                           class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                    <button type="button" onclick="togglePasswordVisibility('current_password', 'eye-current')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="eye-current" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                    New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-shield-halved text-xs"></i>
                    </span>
                    <input type="password" id="password" name="password" required placeholder="Minimum 8 characters"
                           class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                    <button type="button" onclick="togglePasswordVisibility('password', 'eye-new')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="eye-new" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-check-double text-xs"></i>
                    </span>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter new password"
                           class="w-full pl-10 pr-10 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-confirm')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="eye-confirm" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Password Advice Box -->
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-xs space-y-1.5 text-slate-600 dark:text-slate-400">
                <p class="font-bold text-slate-800 dark:text-slate-200 text-xs">Password Recommendations:</p>
                <div class="flex items-center gap-2 text-[11px]">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                    <span>At least 8 characters long</span>
                </div>
                <div class="flex items-center gap-2 text-[11px]">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                    <span>Include uppercase, lowercase letters, numbers, and symbols</span>
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="border-t border-slate-100 dark:border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('user.profile') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    ← Back to Profile Settings
                </a>

                <button type="submit" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-8 py-3 rounded-xl text-xs sm:text-sm transition-all shadow-md active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-lock text-xs"></i>
                    <span>Update Password</span>
                </button>
            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
    function togglePasswordVisibility(fieldId, iconId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash text-xs';
        } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye text-xs';
        }
    }
</script>
@endpush
@endsection
