@extends('layouts.admin.admin')

@section('title', 'Edit AI Feature Card | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.ai-features.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">AI Features</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Edit: {{ $aiFeature->title }}</span>
@endsection

@section('content')

    <!-- Top Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Edit AI Feature Card: {{ $aiFeature->title }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Update card title, image illustration, description, link, or display order.
            </p>
        </div>
        <a href="{{ route('admin.ai-features.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs max-w-4xl">
        <form action="{{ route('admin.ai-features.update', $aiFeature) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Badge / Category -->
                <div>
                    <label for="badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Category Badge (Optional)
                    </label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $aiFeature->badge) }}" placeholder="e.g. Deep Research, Analytics, Creative Media" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('badge')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Card Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $aiFeature->title) }}" placeholder="e.g. Researcher, Analyst, OneDrive AI Restyle" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Provide a detailed explanation of this AI capability..." required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all leading-relaxed">{{ old('description', $aiFeature->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Button Link URL
                    </label>
                    <input type="text" id="link_url" name="link_url" value="{{ old('link_url', $aiFeature->link_url) }}" placeholder="e.g. #plans or https://copilot.microsoft.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('link_url')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link Text -->
                <div>
                    <label for="link_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Button Link Text
                    </label>
                    <input type="text" id="link_text" name="link_text" value="{{ old('link_text', $aiFeature->link_text) }}" placeholder="e.g. See Copilot plans, Learn more" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('link_text')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Illustration Preview & Preset Selection -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-28 h-18 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden flex items-center justify-center shrink-0">
                            @if($aiFeature->image)
                                <img src="{{ asset($aiFeature->image) }}" alt="{{ $aiFeature->title }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-regular fa-image text-slate-400"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Current Image: {{ basename($aiFeature->image) }}</p>
                            <p class="text-[11px] text-slate-400">Select a preset illustration below or upload a replacement file.</p>
                        </div>
                    </div>

                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Change Preset AI Illustration Image
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        @php
                            $presetAiImages = [
                                'assets/img/ai-features/Researcher.png' => 'Researcher',
                                'assets/img/ai-features/Analyst.png' => 'Analyst',
                                'assets/img/ai-features/OneDrive AI Restyle.png' => 'OneDrive AI Restyle',
                                'assets/img/ai-features/Edit with Copilot.png' => 'Edit with Copilot',
                                'assets/img/ai-features/Audio Overviews.png' => 'Audio Overviews',
                                'assets/img/ai-features/AI Rewrite in Teams.png' => 'AI Rewrite in Teams',
                                'assets/img/ai-features/More AI usage.png' => 'More AI usage',
                            ];
                        @endphp
                        @foreach($presetAiImages as $path => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="preset_image" value="{{ $path }}" class="peer sr-only" {{ old('preset_image', $aiFeature->image) === $path ? 'checked' : '' }}>
                                <div class="p-2 rounded-xl border border-transparent peer-checked:border-[#0067b8] peer-checked:bg-white dark:peer-checked:bg-slate-800 peer-checked:shadow-sm hover:bg-white/60 dark:hover:bg-slate-800/60 transition-all flex flex-col items-center justify-center text-center">
                                    <img src="{{ asset($path) }}" alt="{{ $label }}" class="h-20 w-full object-cover rounded-lg mb-1.5">
                                    <span class="text-[10px] font-semibold text-slate-700 dark:text-slate-300 truncate w-full">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Illustration Image Upload -->
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Or Upload Replacement Custom Image
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Leave blank to keep existing image.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Sort Order
                    </label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $aiFeature->sort_order) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('sort_order')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $aiFeature->is_active) ? 'checked' : '' }} class="w-4 h-4 text-[#0067b8] rounded border-slate-300 dark:border-slate-700 focus:ring-[#0067b8]">
                        <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">Active (Visible in slider)</span>
                    </label>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.ai-features.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                    Update AI Card
                </button>
            </div>
        </form>
    </div>

@endsection
