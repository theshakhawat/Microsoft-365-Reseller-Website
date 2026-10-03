@extends('layouts.admin.admin')

@section('title', 'Edit User: ' . $user->name . ' | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.users.index', ['role' => $user->role]) }}" class="hover:text-[#0067b8] transition-colors">
            {{ $user->role === 'admin' ? 'Admins' : 'Customers' }}
        </a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Edit #{{ $user->id }}</span>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <span>Edit Account: {{ $user->name }}</span>
                @if(Auth::id() === $user->id)
                    <span class="text-xs px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 font-bold">Your Account</span>
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Update account details, role permissions, profile picture, or reset password.
            </p>
        </div>
        <a href="{{ route('admin.users.index', ['role' => $user->role]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-xs sm:text-sm font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 shadow-xs">
            <div class="flex items-center gap-3 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">Please correct the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden p-6 sm:p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar & Role Selection Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                
                <!-- Avatar Upload with Live Preview -->
                <div class="flex flex-col items-center justify-center text-center">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Profile Picture</label>
                    <div class="relative group cursor-pointer" onclick="document.getElementById('photo-input').click()">
                        <div id="avatar-preview-container" class="w-24 h-24 rounded-2xl bg-slate-200 dark:bg-slate-700 text-slate-400 dark:text-slate-500 border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center overflow-hidden group-hover:border-[#0067b8] transition-colors">
                            @if($user->photo)
                                <img id="avatar-img" src="{{ asset($user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover" />
                                <i id="avatar-icon" class="fa-solid fa-cloud-arrow-up text-2xl hidden"></i>
                            @else
                                <i id="avatar-icon" class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                <img id="avatar-img" src="" alt="Preview" class="w-full h-full object-cover hidden" />
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold">
                            Change
                        </div>
                    </div>
                    <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    <p class="text-[11px] text-slate-400 mt-2">Click image to change (Max 2MB)</p>
                </div>

                <!-- Account Role Selection -->
                <div class="md:col-span-2 space-y-3 flex flex-col justify-center">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                        Account Role <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-start p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-[#0067b8] transition-colors has-checked:border-[#0067b8] has-checked:bg-blue-50/50 dark:has-checked:bg-blue-950/30">
                            <input type="radio" name="role" value="user" {{ old('role', $user->role) === 'user' ? 'checked' : '' }} class="mt-0.5 text-[#0067b8] focus:ring-[#0067b8]">
                            <div class="ml-3">
                                <span class="block text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <i class="fa-solid fa-user text-blue-500 text-xs"></i>
                                    Customer
                                </span>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Customer portal & purchasing access.</span>
                            </div>
                        </label>

                        <label class="relative flex items-start p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-purple-600 transition-colors has-checked:border-purple-600 has-checked:bg-purple-50/50 dark:has-checked:bg-purple-950/30">
                            <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} class="mt-0.5 text-purple-600 focus:ring-purple-600">
                            <div class="ml-3">
                                <span class="block text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-shield text-purple-600 text-xs"></i>
                                    Administrator
                                </span>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Full backend control & management.</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Credentials and Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-regular fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="e.g. John Doe" class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="e.g. john@example.com" class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Phone Number <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +880 1700 000000" class="w-full pl-9 pr-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- Optional Password Change -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        New Password <span class="text-slate-400 font-normal">(Leave blank to keep unchanged)</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="password" id="password" name="password" minlength="8" placeholder="Enter new password (min 8 chars)" class="w-full pl-9 pr-10 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Active Status Switch -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Account Active Status</p>
                    <p class="text-[11px] text-slate-400">
                        @if(Auth::id() === $user->id)
                            <span class="text-amber-600 dark:text-amber-400 font-semibold">Self status protection is active.</span>
                        @else
                            Deactivated users will not be able to log in.
                        @endif
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }} {{ Auth::id() === $user->id ? 'disabled' : '' }} class="sr-only peer">
                    @if(Auth::id() === $user->id)
                        <input type="hidden" name="status" value="1">
                    @endif
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0067b8]"></div>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index', ['role' => $user->role]) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs font-bold shadow-md shadow-[#0067b8]/25 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Changes</span>
                </button>
            </div>

        </form>
    </div>

</div>

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('avatar-img');
                const icon = document.getElementById('avatar-icon');
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if (icon) icon.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
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
</script>
@endpush
@endsection
