@extends('layouts.admin.admin')

@section('title', 'Change Admin Password | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        Security
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Change Password
    </span>
@endsection

@section('content')

    <!-- Success / Error Notifications -->
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0"></i>
            <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
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

    <!-- Security Box -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden max-w-3xl">
        
        <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Admin Security Credentials</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Protect your administrative account with a strong, distinct password.</p>
            </div>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    Current Admin Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-key text-xs"></i>
                    </span>
                    <input type="password" id="current_password" name="current_password" required class="w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-[#0067b8] focus:bg-white dark:focus:bg-slate-900 transition-all outline-none" placeholder="Enter current administrative password" />
                    <button type="button" onclick="togglePassVisibility('current_password', 'current_eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="current_eye" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    New Strong Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-shield text-xs"></i>
                    </span>
                    <input type="password" id="password" name="password" required minlength="8" class="w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-[#0067b8] focus:bg-white dark:focus:bg-slate-900 transition-all outline-none" placeholder="Minimum 8 characters with numbers/symbols" />
                    <button type="button" onclick="togglePassVisibility('password', 'new_eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="new_eye" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-check-double text-xs"></i>
                    </span>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" class="w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-[#0067b8] focus:bg-white dark:focus:bg-slate-900 transition-all outline-none" placeholder="Re-type new password" />
                    <button type="button" onclick="togglePassVisibility('password_confirmation', 'confirm_eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                        <i id="confirm_eye" class="fa-regular fa-eye text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-7 py-3 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all flex items-center gap-2 active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-lock-open text-xs"></i>
                    <span>Update Password</span>
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    function togglePassVisibility(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }
</script>
@endpush
