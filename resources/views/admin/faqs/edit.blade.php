@extends('layouts.admin.admin')

@section('title', 'Edit FAQ | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.faqs.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        FAQs
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Edit FAQ
    </span>
@endsection

@section('content')

    <!-- Top Bar -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Edit FAQ
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Update question details and answers for "{{ Str::limit($faq->question, 40) }}".
            </p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Question Input -->
            <div class="space-y-1.5">
                <label for="question" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Question <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('question') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50' }} text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-[#0067b8]/20 focus:border-[#0067b8] transition-all">
                @error('question')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Answer Textarea -->
            <div class="space-y-1.5">
                <label for="answer" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Answer <span class="text-rose-500">*</span>
                </label>
                <textarea name="answer" id="answer" rows="5" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('answer') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50' }} text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-[#0067b8]/20 focus:border-[#0067b8] transition-all leading-relaxed">{{ old('answer', $faq->answer) }}</textarea>
                <p class="text-[11px] text-slate-400 dark:text-slate-500">You can use standard HTML formatting such as &lt;a href="..." target="_blank"&gt;link&lt;/a&gt; if needed.</p>
                @error('answer')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                
                <!-- Sort Order -->
                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Display Order / Numbering
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" min="0" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 text-slate-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-[#0067b8]/20 focus:border-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">Will be shown as 01/, 02/, 03/ etc.</p>
                    @error('sort_order')
                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Toggles Box -->
                <div class="space-y-4 pt-1 sm:pt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_default_open" value="1" {{ old('is_default_open', $faq->is_default_open) ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0067b8] border-slate-300 dark:border-slate-700 focus:ring-[#0067b8]">
                        <div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Open by Default</span>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Expand this accordion item initially when page loads.</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ? '1' : '0') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0067b8] border-slate-300 dark:border-slate-700 focus:ring-[#0067b8]">
                        <div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Active & Visible</span>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Show this FAQ on the public storefront.</p>
                        </div>
                    </label>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                    Update FAQ
                </button>
            </div>

        </form>
    </div>

@endsection
