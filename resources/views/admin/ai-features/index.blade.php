@extends('layouts.admin.admin')

@section('title', 'AI Features Carousel Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        AI Features
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

    <!-- Page Title & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                AI Capabilities Slider Management
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the horizontal AI capability slider cards in the "Intelligent Capabilities" section.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#ai-features" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.ai-features.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add AI Card</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total AI Cards</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-robot"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Visible</p>
                <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $stats['active'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hidden</p>
                <p class="text-xl font-black text-slate-500 dark:text-slate-400 mt-0.5">{{ $stats['hidden'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
        </div>
    </div>

    <!-- AI Feature Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($features as $feature)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-200">
                
                <div>
                    <!-- Visual Image Header -->
                    <div class="h-44 w-full overflow-hidden bg-slate-100 dark:bg-slate-800 relative border-b border-slate-100 dark:border-slate-800">
                        @if($feature->image)
                            <img src="{{ asset($feature->image) }}" alt="{{ $feature->title }}" class="w-full h-full object-cover object-center">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        @endif

                        <!-- Floating Status Switcher Badge -->
                        <div class="absolute top-3 right-3">
                            <form action="{{ route('admin.ai-features.toggle', $feature) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md cursor-pointer transition-all shadow-xs {{ $feature->is_active ? 'bg-emerald-500/90 text-white hover:bg-emerald-600' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-800' }}" title="Click to Toggle Active Status">
                                    <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $feature->is_active ? 'bg-white' : 'bg-slate-400' }}"></span>
                                    {{ $feature->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 sm:p-6">
                        @if($feature->badge)
                            <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">
                                {{ $feature->badge }}
                            </span>
                        @endif

                        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug">
                            {{ $feature->title }}
                        </h3>

                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3 mb-4">
                            {{ $feature->description }}
                        </p>

                        <!-- Link Info -->
                        <div class="text-[11px] font-semibold text-[#0067b8] dark:text-sky-400 flex items-center gap-1.5">
                            <span class="w-5 h-5 rounded-full bg-[#0067b8] text-white flex items-center justify-center text-[9px]">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                            <span>{{ $feature->link_text ?? 'See Copilot plans' }}</span>
                            <span class="text-slate-400 text-[10px]">({{ $feature->link_url ?? '#plans' }})</span>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-5 sm:px-6 pb-5 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                    <span class="text-[10px] text-slate-400 font-bold bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-md">
                        Order: {{ $feature->sort_order }}
                    </span>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.ai-features.edit', $feature) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit Card">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- Custom Delete Modal Trigger -->
                        <button type="button" onclick="openDeleteModal('{{ route('admin.ai-features.destroy', $feature) }}', '{{ addslashes($feature->title) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete Card">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-robot text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No AI Feature Cards Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to add your first AI slider feature card.</p>
                <a href="{{ route('admin.ai-features.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add AI Card
                </a>
            </div>
        @endforelse
    </div>

@endsection
