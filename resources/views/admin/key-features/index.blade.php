@extends('layouts.admin.admin')

@section('title', 'Key Features Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Key Features
    </span>
@endsection

@section('content')

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0"></i>
            <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Page Title & Create Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Key Features Management
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the dynamic Key Feature cards shown under the hero section on the homepage.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#key-features" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.key-features.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Feature</span>
            </a>
        </div>
    </div>

    <!-- Feature Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($features as $feature)
            @php
                $bgClass = match($feature->icon_bg_color) {
                    'purple' => 'bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 border-purple-100 dark:border-purple-900/50',
                    'indigo' => 'bg-indigo-50 dark:bg-indigo-950/50 text-[#5059c9] dark:text-indigo-400 border-indigo-100 dark:border-indigo-900/50',
                    'blue' => 'bg-blue-50 dark:bg-blue-950/50 text-[#0078d4] dark:text-sky-400 border-blue-100 dark:border-blue-900/50',
                    'amber' => 'bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/50',
                    'emerald' => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/50',
                    'rose' => 'bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 border-rose-100 dark:border-rose-900/50',
                    default => 'bg-sky-50 dark:bg-sky-950/50 text-[#0078d4] dark:text-sky-400 border-sky-100 dark:border-sky-900/50',
                };
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-200">
                
                <div>
                    <!-- Top Bar: Icon & Status Switcher -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="w-10 h-10 rounded-xl {{ $bgClass }} border flex items-center justify-center text-lg shadow-2xs">
                            <i class="{{ $feature->icon }}"></i>
                        </div>

                        <form action="{{ route('admin.key-features.toggle', $feature) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[11px] font-bold px-2.5 py-1 rounded-full cursor-pointer transition-all {{ $feature->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Status">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $feature->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $feature->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1.5 leading-snug">
                        {{ $feature->title }}
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-3 line-clamp-3">
                        {{ $feature->description }}
                    </p>

                    <!-- Link Info -->
                    <div class="text-[11px] font-semibold text-[#0067b8] dark:text-sky-400 flex items-center gap-1 mb-4">
                        <span>{{ $feature->link_text ?? 'Learn more' }}</span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        <span class="text-slate-400 text-[10px] ml-1">({{ $feature->link_url ?? '#plans' }})</span>
                    </div>

                    <!-- Image Preview -->
                    <div class="rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-800 h-36 flex items-center justify-center p-2 mb-4">
                        @if($feature->image)
                            <img src="{{ asset($feature->image) }}" alt="{{ $feature->title }}" class="w-full h-full object-contain">
                        @else
                            <div class="text-center text-slate-400 text-xs">
                                <i class="fa-regular fa-image text-2xl mb-1 block opacity-50"></i>
                                <span>No image assigned</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer: Sort Order & Action Buttons -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                    <span class="text-[10px] text-slate-400 font-bold bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                        Sort Order: {{ $feature->sort_order }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.key-features.edit', $feature) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit Feature">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- Custom Modal Delete Trigger -->
                        <button type="button" onclick="openDeleteModal('{{ route('admin.key-features.destroy', $feature) }}', '{{ addslashes($feature->title) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete Feature">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-wand-magic-sparkles text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No Key Features Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to create your first Key Feature card.</p>
                <a href="{{ route('admin.key-features.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add Feature
                </a>
            </div>
        @endforelse
    </div>

@endsection
