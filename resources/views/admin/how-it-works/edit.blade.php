@extends('layouts.admin.admin')

@section('title', 'Edit How It Works Step | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.how-it-works.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400">How It Works</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Edit: {{ $howItWork->title }}</span>
@endsection

@section('content')

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Edit Step: {{ $howItWork->title }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Update the step details, icon class, badge and active visibility.
            </p>
        </div>
        <a href="{{ route('admin.how-it-works.index') }}" class="flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to Steps</span>
        </a>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.how-it-works.update', $howItWork) }}" method="POST" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 space-y-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Step Number -->
            <div>
                <label for="step_number" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Step Number / Badge (e.g. 01, 02)
                </label>
                <input type="text" name="step_number" id="step_number" value="{{ old('step_number', $howItWork->step_number) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8] focus:ring-1 focus:ring-[#0067b8]">
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Step Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $howItWork->title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8] focus:ring-1 focus:ring-[#0067b8]">
            </div>

            <!-- Description -->
            <div class="col-span-full">
                <label for="description" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Step Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" id="description" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8] focus:ring-1 focus:ring-[#0067b8]">{{ old('description', $howItWork->description) }}</textarea>
            </div>

            <!-- Icon (FontAwesome Class) -->
            <div>
                <label for="icon" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    FontAwesome Icon Class <span class="text-red-500">*</span>
                </label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', $howItWork->icon) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8] focus:ring-1 focus:ring-[#0067b8]">
                <p class="text-[11px] text-slate-400 mt-1">Example icons: <code>fa-solid fa-layer-group</code>, <code>fa-solid fa-credit-card</code>, <code>fa-solid fa-clock-rotate-left</code>, <code>fa-solid fa-shield-halved</code></p>
            </div>

            <!-- Icon Background Color Theme -->
            <div>
                <label for="icon_bg_color" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Icon Theme Color
                </label>
                <select name="icon_bg_color" id="icon_bg_color" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8]">
                    <option value="sky" {{ old('icon_bg_color', $howItWork->icon_bg_color) == 'sky' ? 'selected' : '' }}>Blue / Sky</option>
                    <option value="purple" {{ old('icon_bg_color', $howItWork->icon_bg_color) == 'purple' ? 'selected' : '' }}>Purple</option>
                    <option value="amber" {{ old('icon_bg_color', $howItWork->icon_bg_color) == 'amber' ? 'selected' : '' }}>Amber / Orange</option>
                    <option value="emerald" {{ old('icon_bg_color', $howItWork->icon_bg_color) == 'emerald' ? 'selected' : '' }}>Emerald / Green</option>
                </select>
            </div>

            <!-- Badge Text -->
            <div>
                <label for="badge_text" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Footer Badge Text (Optional)
                </label>
                <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $howItWork->badge_text) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8]">
            </div>

            <!-- Badge Icon -->
            <div>
                <label for="badge_icon" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Badge Icon Class
                </label>
                <input type="text" name="badge_icon" id="badge_icon" value="{{ old('badge_icon', $howItWork->badge_icon) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8]">
            </div>

            <!-- Badge Color -->
            <div>
                <label for="badge_color" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Badge Color
                </label>
                <select name="badge_color" id="badge_color" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8]">
                    <option value="emerald" {{ old('badge_color', $howItWork->badge_color) == 'emerald' ? 'selected' : '' }}>Green / Emerald</option>
                    <option value="amber" {{ old('badge_color', $howItWork->badge_color) == 'amber' ? 'selected' : '' }}>Amber / Orange</option>
                    <option value="sky" {{ old('badge_color', $howItWork->badge_color) == 'sky' ? 'selected' : '' }}>Blue / Sky</option>
                    <option value="purple" {{ old('badge_color', $howItWork->badge_color) == 'purple' ? 'selected' : '' }}>Purple</option>
                </select>
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Sort Order (Sequence)
                </label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $howItWork->sort_order) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:border-[#0067b8]">
            </div>

            <!-- Active Checkbox -->
            <div class="col-span-full pt-2">
                <label class="inline-flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $howItWork->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-[#0067b8] focus:ring-[#0067b8] border-slate-300">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Active (Visible on Homepage)</span>
                </label>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
            <a href="{{ route('admin.how-it-works.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-bold transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/20 transition-all cursor-pointer">
                Update Step
            </button>
        </div>
    </form>

@endsection
