@extends('layouts.admin.admin')

@section('title', 'FAQ Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        FAQs (Did you know?)
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
                FAQ Management ("Did you know?")
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the frequently asked questions accordion displayed on the homepage.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#faq" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.faqs.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New FAQ</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total FAQs</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-circle-question"></i>
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
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Default Open</p>
                <p class="text-xl font-black text-indigo-600 dark:text-indigo-400 mt-0.5">{{ $stats['default_open'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-folder-open"></i>
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

    <!-- FAQ Accordion List -->
    <div class="space-y-4">
        @forelse($faqs as $index => $faq)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition-all duration-200">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    
                    <!-- Left: Numbering & Question & Answer preview -->
                    <div class="flex items-start gap-4 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center font-mono font-bold text-xs shrink-0 shadow-2xs border border-slate-200/60 dark:border-slate-700/60">
                            {{ sprintf('%02d/', $faq->sort_order ?: ($index + 1)) }}
                        </div>
                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white leading-snug">
                                    {{ $faq->question }}
                                </h3>
                                @if($faq->is_default_open)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-950/80 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                        Open by Default
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl prose-sm dark:prose-invert">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>

                    <!-- Right: Badges & Action Buttons -->
                    <div class="flex items-center sm:justify-end gap-2 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100 dark:border-slate-800">
                        <form action="{{ route('admin.faqs.toggle', $faq) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[11px] font-bold px-3 py-1.5 rounded-xl cursor-pointer transition-all {{ $faq->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-100 border border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 border border-slate-200 dark:border-slate-700' }}" title="Click to Toggle Active Status">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $faq->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $faq->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="p-2 rounded-xl text-slate-500 hover:text-[#0067b8] hover:bg-blue-50 dark:hover:bg-blue-950/50 transition-colors" title="Edit FAQ">
                            <i class="fa-regular fa-pen-to-square text-sm"></i>
                        </a>

                        <button type="button" onclick="openDeleteModal('{{ route('admin.faqs.destroy', $faq) }}', '{{ addslashes($faq->question) }}')" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors cursor-pointer" title="Delete FAQ">
                            <i class="fa-regular fa-trash-can text-sm"></i>
                        </button>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-950/50 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">No FAQ items yet</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                    Get started by adding questions and answers to the FAQ accordion section.
                </p>
                <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center gap-2 mt-5 bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-4 py-2.5 rounded-xl text-xs shadow-md transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add First FAQ</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Custom Delete Confirmation Modal Popup -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 max-w-md w-full shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            
            <div class="text-center space-y-2">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Confirm Deletion</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Are you sure you want to delete <span id="deleteItemTitle" class="font-bold text-slate-800 dark:text-slate-200"></span>? This action cannot be undone.
                </p>
            </div>

            <form id="deleteForm" method="POST" class="flex gap-3 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition-colors cursor-pointer">
                    Yes, Delete FAQ
                </button>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl, itemName) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteItemTitle').textContent = `"${itemName}"`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

@endsection
