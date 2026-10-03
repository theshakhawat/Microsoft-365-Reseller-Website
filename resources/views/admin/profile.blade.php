@extends('layouts.admin.admin')

@section('title', 'Admin Profile Settings | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 dark:text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        Settings
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Admin Profile
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

    <!-- Profile Settings Form Container -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
        
        <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Admin Personal Details</h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Update your administrative profile name, contact phone, and avatar photo.</p>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- Profile Photo with Live Preview -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-4">
                    Admin Avatar Photo
                </label>
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    
                    <!-- Image Preview Area -->
                    <div class="relative group">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl overflow-hidden border-2 border-[#0067b8]/30 dark:border-sky-500/30 bg-slate-100 dark:bg-slate-800 flex items-center justify-center shadow-lg">
                            <img id="avatar-preview" src="{{ $user->photo ? asset($user->photo) : '' }}" class="{{ $user->photo ? '' : 'hidden' }} w-full h-full object-cover" alt="Profile Preview" />
                            <div id="avatar-placeholder" class="{{ $user->photo ? 'hidden' : 'flex' }} w-full h-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-black text-3xl items-center justify-center">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <label for="photo-input" class="absolute -bottom-2 -right-2 w-9 h-9 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white flex items-center justify-center cursor-pointer shadow-md transition-transform hover:scale-110 active:scale-95" title="Change Avatar">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </label>
                    </div>

                    <!-- Upload Details & Input -->
                    <div class="space-y-2 text-center sm:text-left flex-1">
                        <input type="file" id="photo-input" name="photo" accept="image/*" onchange="previewProfilePic(event)" class="hidden" />
                        <button type="button" onclick="document.getElementById('photo-input').click()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors border border-slate-200 dark:border-slate-700 cursor-pointer">
                            <i class="fa-solid fa-cloud-arrow-up text-xs text-[#0067b8] dark:text-sky-400"></i>
                            <span>Upload New Image</span>
                        </button>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">
                            Recommended: Square PNG, JPG or WebP (Max 2MB).
                        </p>
                    </div>

                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Inputs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-[#0067b8] focus:bg-white dark:focus:bg-slate-900 transition-all outline-none" placeholder="e.g. System Administrator" />
                    </div>
                </div>

                <!-- Email Address (Read-only for security) -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Email Address <span class="text-slate-400 lowercase font-normal">(Primary Login ID)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" value="{{ $user->email }}" disabled class="w-full pl-10 pr-4 py-3 bg-slate-100 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/60 rounded-xl text-xs sm:text-sm font-semibold text-slate-500 dark:text-slate-400 cursor-not-allowed outline-none" />
                    </div>
                </div>

                <!-- Phone Contact -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Contact Phone Number
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </span>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-[#0067b8] focus:bg-white dark:focus:bg-slate-900 transition-all outline-none" placeholder="e.g. 01342325558" />
                    </div>
                </div>

                <!-- System Role Badge -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Current Role
                    </label>
                    <div class="py-3 px-4 bg-purple-50/70 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800/60 rounded-xl flex items-center justify-between">
                        <span class="text-xs font-bold text-purple-700 dark:text-purple-300 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                            Super Administrator
                        </span>
                        <span class="text-[10px] font-bold uppercase bg-purple-200/80 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-0.5 rounded">All Permissions</span>
                    </div>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-7 py-3 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all flex items-center gap-2 active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save Changes</span>
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    function previewProfilePic(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
