@extends('layouts.user.user')

@section('title', 'Profile Settings | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Profile Settings</span>
@endsection

@section('content')

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
            <span>Please fix the following errors:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700 dark:text-red-300">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Form Card -->
    <div class="max-w-4xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-9 shadow-xs">
        
        <div class="pb-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Personal Details</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Update your account name, contact number, and profile avatar.</p>
            </div>
            <span class="text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-3 py-1 rounded-full self-start sm:self-auto">
                Status: Active Account
            </span>
        </div>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-8">
            @csrf

            <!-- Profile Photo Upload with Live Preview -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4">
                    Profile Photo
                </label>
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    
                    <!-- Image Preview Container -->
                    <div class="relative group">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-slate-100 dark:bg-slate-800 border-2 border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center overflow-hidden shadow-xs">
                            <img id="photo-preview" 
                                 src="{{ $user->photo ? asset($user->photo) : '' }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover {{ $user->photo ? '' : 'hidden' }}" />
                            
                            <div id="photo-placeholder" class="text-center p-2 {{ $user->photo ? 'hidden' : '' }}">
                                <div class="w-12 h-12 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 mx-auto flex items-center justify-center text-xl font-bold mb-1">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-[10px] font-bold text-slate-400">No Photo</span>
                            </div>
                        </div>

                        <label for="photo-input" class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-[#0067b8] hover:bg-[#005a9e] text-white flex items-center justify-center shadow-md cursor-pointer transition-transform hover:scale-110 active:scale-95" title="Choose Photo">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </label>
                    </div>

                    <!-- Photo Upload Info & Actions -->
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-3">
                            <label for="photo-input" class="bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 transition-colors cursor-pointer inline-flex items-center gap-2">
                                <i class="fa-solid fa-arrow-up-from-bracket text-xs"></i>
                                <span>Upload New Photo</span>
                            </label>
                            <button type="button" onclick="clearPreview()" id="clear-photo-btn" class="hidden text-xs font-semibold text-red-500 hover:underline">
                                Remove Selected
                            </button>
                        </div>
                        <input type="file" id="photo-input" name="photo" accept="image/*" onchange="previewProfilePic(event)" class="hidden" />
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">
                            Supported formats: PNG, JPG, JPEG, WEBP. Maximum file size: 2MB.
                        </p>
                    </div>

                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-800 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user text-xs"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Phone Number (bKash / Contact)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </span>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1XXXXXXXXX"
                               class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white font-medium focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
                    </div>
                </div>

                <!-- Email Address (Read-Only) -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Email Address <span class="text-slate-400 font-normal">(Linked Microsoft Account ID)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" id="email" value="{{ $user->email }}" readonly
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium cursor-not-allowed">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">To change your primary email, contact customer support.</p>
                </div>

                <!-- Account Role & Registration Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                        Account Role & Registration
                    </label>
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-between">
                        <span class="text-xs font-bold uppercase text-[#0067b8] dark:text-sky-400 bg-sky-100 dark:bg-sky-950 px-2.5 py-0.5 rounded-md">
                            {{ $user->role }}
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Joined {{ $user->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Submit Actions -->
            <div class="border-t border-slate-100 dark:border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('user.password') }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline flex items-center gap-1.5">
                    <i class="fa-solid fa-key text-xs"></i>
                    <span>Want to change your account password instead?</span>
                </a>

                <button type="submit" class="w-full sm:w-auto bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-8 py-3 rounded-xl text-xs sm:text-sm transition-all shadow-md active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save Profile Changes</span>
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    // Live Profile Image Preview Controller
    function previewProfilePic(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                const placeholder = document.getElementById('photo-placeholder');
                const clearBtn = document.getElementById('clear-photo-btn');

                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (clearBtn) clearBtn.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function clearPreview() {
        const input = document.getElementById('photo-input');
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        const clearBtn = document.getElementById('clear-photo-btn');
        
        input.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
        if (clearBtn) clearBtn.classList.add('hidden');
    }
</script>
@endpush
