@extends('layouts.admin.admin')

@section('title', 'Included Apps Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Included Apps
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

    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Included Apps Management
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the dynamic "What's Included" app cards (Productivity & Security tabs) on the storefront.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#included-apps" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.included-apps.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New App</span>
            </a>
        </div>
    </div>

    <!-- Stats & Filters Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs">
        
        <!-- Category Filter Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.included-apps.index', ['category' => 'all']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ ($category ?? 'all') === 'all' ? 'bg-[#0067b8] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                All Apps ({{ $stats['total'] ?? 0 }})
            </a>
            <a href="{{ route('admin.included-apps.index', ['category' => 'productivity']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ ($category ?? '') === 'productivity' ? 'bg-[#0067b8] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-shapes text-[11px] mr-1"></i>
                Productivity ({{ $stats['productivity'] ?? 0 }})
            </a>
            <a href="{{ route('admin.included-apps.index', ['category' => 'security']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ ($category ?? '') === 'security' ? 'bg-[#0067b8] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-shield-halved text-[11px] mr-1"></i>
                Security & Storage ({{ $stats['security'] ?? 0 }})
            </a>
        </div>

        <!-- Active Badges Info -->
        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2 shrink-0">
            <span class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 px-2.5 py-1 rounded-lg border border-emerald-200/60 dark:border-emerald-800">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>{{ $stats['active'] ?? 0 }} Active</span>
            </span>
        </div>
    </div>

    <!-- App Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
        @forelse($apps as $app)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-200">
                
                <div>
                    <!-- Top Bar: Icon, Category Badge & Status Switcher -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700/60 flex items-center justify-center p-2 shadow-2xs shrink-0">
                            @if($app->icon_image)
                                <img src="{{ asset($app->icon_image) }}" alt="{{ $app->name }}" class="w-full h-full object-contain">
                            @else
                                <i class="fa-solid fa-shapes text-slate-400 text-lg"></i>
                            @endif
                        </div>

                        <div class="flex flex-col items-end gap-1.5">
                            <form action="{{ route('admin.included-apps.toggle', $app) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold px-2 py-0.5 rounded-full cursor-pointer transition-all {{ $app->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Active Status">
                                    <span class="w-1.5 h-1.5 rounded-full inline-block mr-0.5 {{ $app->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $app->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </form>

                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md {{ $app->category === 'productivity' ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-400 border border-blue-100 dark:border-blue-900/50' : 'bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-400 border border-purple-100 dark:border-purple-900/50' }}">
                                {{ $app->category === 'productivity' ? 'Productivity' : 'Security' }}
                            </span>
                        </div>
                    </div>

                    <!-- Name & Tagline -->
                    <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">
                        {{ $app->name }}
                    </span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug">
                        {{ $app->tagline }}
                    </h3>

                    <!-- Description -->
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3 mb-4">
                        {{ $app->description }}
                    </p>

                    <!-- Link Info -->
                    <div class="text-[11px] font-semibold text-[#0067b8] dark:text-sky-400 flex items-center gap-1 mb-2">
                        <span>{{ $app->link_text ?? 'Learn more' }}</span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        <span class="text-slate-400 text-[10px] ml-1 truncate max-w-[130px]" title="{{ $app->link_url }}">({{ $app->link_url ?? '#plans' }})</span>
                    </div>
                </div>

                <!-- Footer: Sort Order & Action Buttons -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2 mt-2">
                    <span class="text-[10px] text-slate-400 font-bold bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                        Sort: {{ $app->sort_order }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.included-apps.edit', $app) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit App">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- Custom Delete Trigger Modal -->
                        <button type="button" onclick="openDeleteModal('{{ route('admin.included-apps.destroy', $app) }}', '{{ addslashes($app->name . ' - ' . $app->tagline) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete App">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-shapes text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No Included Apps Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to create your first Included App card.</p>
                <a href="{{ route('admin.included-apps.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add New App
                </a>
            </div>
        @endforelse
    </div>

@endsection
