@extends('layouts.admin.admin')

@section('title', 'System & Error Logs - Admin Control Center')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <span>System Logs</span>
        <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2 py-0.5 rounded-full">
            {{ $fileStats['name'] }}
        </span>
    </span>
@endsection

@section('content')
<div class="space-y-6">

    <!-- ================================================================= -->
    <!-- 1. HEADER BANNER & ACTIONS                                        -->
    <!-- ================================================================= -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
        <div class="space-y-1.5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-[11px] font-black uppercase tracking-wider bg-slate-900 text-white dark:bg-white dark:text-slate-900 px-2.5 py-0.5 rounded-md flex items-center gap-1.5">
                    <i class="fa-solid fa-terminal text-xs text-sky-400 dark:text-[#0067b8]"></i>
                    <span>Laravel Storage Logs</span>
                </span>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                    File: <code class="font-mono text-slate-800 dark:text-slate-200 font-bold">{{ $fileStats['name'] }}</code> ({{ $fileStats['size'] }})
                </span>
                <span class="text-[11px] text-slate-400">• Last modified: {{ $fileStats['modified_at'] }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                Application & Server Error Logs
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-2xl">
                Inspect real-time exceptions, background queue logs, mailer traces, and debugging information from <code class="font-mono text-[11px]">storage/logs/laravel.log</code>.
            </p>
        </div>

        <!-- Action Controls -->
        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <!-- Mode Toggle -->
            <div class="flex items-center p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                <a href="{{ request()->fullUrlWithQuery(['mode' => 'parsed']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $viewMode !== 'raw' ? 'bg-white dark:bg-slate-900 text-[#0067b8] dark:text-sky-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                    <i class="fa-solid fa-list-check mr-1 text-xs"></i> Parsed
                </a>
                <a href="{{ request()->fullUrlWithQuery(['mode' => 'raw']) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $viewMode === 'raw' ? 'bg-white dark:bg-slate-900 text-[#0067b8] dark:text-sky-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                    <i class="fa-solid fa-code mr-1 text-xs"></i> Raw Tail
                </a>
            </div>

            <!-- Download Log File -->
            <a href="{{ route('admin.logs.download', ['file' => $selectedFile]) }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors" title="Download raw log file">
                <i class="fa-solid fa-download text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Download</span>
            </a>

            <!-- Refresh Button -->
            <a href="{{ request()->fullUrl() }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors" title="Reload logs">
                <i class="fa-solid fa-arrows-rotate text-xs"></i>
                <span>Refresh</span>
            </a>

            <!-- Clear Log Button -->
            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear and empty {{ $fileStats['name'] }}? This action cannot be undone.');" class="inline">
                @csrf
                <input type="hidden" name="file" value="{{ $selectedFile }}">
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-950/50 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/60 font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer" title="Empty log file">
                    <i class="fa-regular fa-trash-can text-xs"></i>
                    <span>Clear Log</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 2. LOG SEVERITY STATS & FILTER TABS                               -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        
        <!-- Tab: ALL -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'ALL']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'ALL' ? 'bg-[#0067b8] text-white border-[#0067b8] shadow-md shadow-[#0067b8]/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'ALL' ? 'text-white/80' : 'text-slate-400' }}">All Entries</span>
                <i class="fa-solid fa-layer-group text-xs {{ $filterLevel === 'ALL' ? 'text-white' : 'text-slate-400' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'ALL' ? 'text-white' : 'text-slate-900 dark:text-white' }}">
                {{ $counts['total'] }}
            </p>
        </a>

        <!-- Tab: ERROR -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'ERROR']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'ERROR' ? 'bg-red-600 text-white border-red-600 shadow-md shadow-red-600/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-red-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'ERROR' ? 'text-white/80' : 'text-red-500' }}">Errors</span>
                <i class="fa-solid fa-circle-exclamation text-xs {{ $filterLevel === 'ERROR' ? 'text-white' : 'text-red-500' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'ERROR' ? 'text-white' : 'text-red-600 dark:text-red-400' }}">
                {{ $counts['error'] }}
            </p>
        </a>

        <!-- Tab: WARNING -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'WARNING']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'WARNING' ? 'bg-amber-500 text-white border-amber-500 shadow-md shadow-amber-500/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-amber-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'WARNING' ? 'text-white/80' : 'text-amber-500' }}">Warnings</span>
                <i class="fa-solid fa-triangle-exclamation text-xs {{ $filterLevel === 'WARNING' ? 'text-white' : 'text-amber-500' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'WARNING' ? 'text-white' : 'text-amber-600 dark:text-amber-400' }}">
                {{ $counts['warning'] }}
            </p>
        </a>

        <!-- Tab: INFO -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'INFO']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'INFO' ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-600/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-blue-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'INFO' ? 'text-white/80' : 'text-blue-500' }}">Info</span>
                <i class="fa-solid fa-circle-info text-xs {{ $filterLevel === 'INFO' ? 'text-white' : 'text-blue-500' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'INFO' ? 'text-white' : 'text-blue-600 dark:text-blue-400' }}">
                {{ $counts['info'] }}
            </p>
        </a>

        <!-- Tab: DEBUG -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'DEBUG']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'DEBUG' ? 'bg-purple-600 text-white border-purple-600 shadow-md shadow-purple-600/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-purple-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'DEBUG' ? 'text-white/80' : 'text-purple-500' }}">Debug</span>
                <i class="fa-solid fa-bug text-xs {{ $filterLevel === 'DEBUG' ? 'text-white' : 'text-purple-500' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'DEBUG' ? 'text-white' : 'text-purple-600 dark:text-purple-400' }}">
                {{ $counts['debug'] }}
            </p>
        </a>

        <!-- Tab: CRITICAL / EMERGENCY -->
        <a href="{{ request()->fullUrlWithQuery(['level' => 'CRITICAL']) }}" class="p-3.5 rounded-2xl border transition-all text-left flex flex-col justify-between {{ $filterLevel === 'CRITICAL' ? 'bg-rose-700 text-white border-rose-700 shadow-md shadow-rose-700/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-rose-400' }}">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider {{ $filterLevel === 'CRITICAL' ? 'text-white/80' : 'text-rose-500' }}">Critical</span>
                <i class="fa-solid fa-fire text-xs {{ $filterLevel === 'CRITICAL' ? 'text-white' : 'text-rose-500' }}"></i>
            </div>
            <p class="text-xl font-black mt-2 {{ $filterLevel === 'CRITICAL' ? 'text-white' : 'text-rose-700 dark:text-rose-400' }}">
                {{ $counts['critical'] + $counts['emergency'] }}
            </p>
        </a>

    </div>

    <!-- ================================================================= -->
    <!-- 3. SEARCH & LOG FILTER FORM                                       -->
    <!-- ================================================================= -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <input type="hidden" name="file" value="{{ $selectedFile }}">
            <input type="hidden" name="level" value="{{ $filterLevel }}">
            <input type="hidden" name="mode" value="{{ $viewMode }}">

            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ $searchQuery }}" 
                       placeholder="Search exception messages, stack traces, keywords (e.g. SMTP, Mailer, Order)..." 
                       class="w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-[#0067b8] focus:border-transparent">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs rounded-xl transition-all shadow-sm cursor-pointer">
                    <span>Search Logs</span>
                </button>
                @if(!empty($searchQuery) || $filterLevel !== 'ALL')
                    <a href="{{ route('admin.logs.index', ['file' => $selectedFile]) }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 font-bold text-xs rounded-xl transition-all">
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- ================================================================= -->
    <!-- 4. LOG ENTRIES VIEW AREA                                          -->
    <!-- ================================================================= -->
    @if($viewMode === 'raw')
        <!-- RAW TERMINAL VIEW -->
        <div class="bg-slate-950 rounded-3xl border border-slate-800 p-5 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="font-mono text-xs text-slate-400 ml-2">Terminal Tail (Last ~600 lines)</span>
                </div>
                <button onclick="navigator.clipboard.writeText(document.getElementById('raw-log-content').innerText); alert('Raw logs copied to clipboard!');" class="text-xs font-mono font-bold text-sky-400 hover:text-sky-300">
                    <i class="fa-regular fa-copy mr-1"></i> Copy Raw
                </button>
            </div>
            <pre id="raw-log-content" class="font-mono text-xs text-slate-300 overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-[600px] overflow-y-auto">{{ $rawContent ?: 'Log file is currently empty.' }}</pre>
        </div>
    @else
        <!-- STRUCTURED PARSED LOG CARDS -->
        <div class="space-y-3">
            @forelse($parsedLogs as $log)
                @php
                    $levelColor = match($log['level']) {
                        'ERROR'    => 'bg-red-50 dark:bg-red-950/40 border-red-200 dark:border-red-900/60 text-red-700 dark:text-red-400',
                        'WARNING'  => 'bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-900/60 text-amber-700 dark:text-amber-400',
                        'INFO'     => 'bg-blue-50 dark:bg-blue-950/40 border-blue-200 dark:border-blue-900/60 text-blue-700 dark:text-blue-400',
                        'DEBUG'    => 'bg-purple-50 dark:bg-purple-950/40 border-purple-200 dark:border-purple-900/60 text-purple-700 dark:text-purple-400',
                        'CRITICAL', 'EMERGENCY' => 'bg-rose-100 dark:bg-rose-950/60 border-rose-300 dark:border-rose-900 text-rose-800 dark:text-rose-300',
                        default    => 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300',
                    };

                    $badgeColor = match($log['level']) {
                        'ERROR'    => 'bg-red-600 text-white',
                        'WARNING'  => 'bg-amber-500 text-white',
                        'INFO'     => 'bg-blue-600 text-white',
                        'DEBUG'    => 'bg-purple-600 text-white',
                        'CRITICAL', 'EMERGENCY' => 'bg-rose-700 text-white',
                        default    => 'bg-slate-600 text-white',
                    };
                @endphp

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden transition-all hover:border-slate-400 dark:hover:border-slate-700">
                    
                    <!-- Entry Header & Message -->
                    <div class="p-4 sm:p-5">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $badgeColor }}">
                                    {{ $log['level'] }}
                                </span>
                                <span class="text-[11px] font-mono font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">
                                    {{ $log['env'] }}
                                </span>
                                <span class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300">
                                    {{ $log['timestamp'] }}
                                </span>
                            </div>

                            @if(!empty($log['trace']))
                                <button type="button" 
                                        onclick="document.getElementById('trace-{{ $log['id'] }}').classList.toggle('hidden');" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold text-[#0067b8] dark:text-sky-400 bg-sky-50 dark:bg-sky-950/60 hover:bg-sky-100 transition-colors cursor-pointer flex items-center gap-1">
                                    <i class="fa-solid fa-code text-[10px]"></i>
                                    <span>Toggle Stack Trace</span>
                                </button>
                            @endif
                        </div>

                        <!-- Main Message -->
                        <div class="p-3 rounded-xl border {{ $levelColor }} font-mono text-xs whitespace-pre-wrap leading-relaxed break-all">
                            {{ $log['message'] }}
                        </div>
                    </div>

                    <!-- Collapsible Stack Trace -->
                    @if(!empty($log['trace']))
                        <div id="trace-{{ $log['id'] }}" class="hidden bg-slate-950 border-t border-slate-800 p-4">
                            <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-800">
                                <span class="text-[11px] font-mono text-slate-400 font-bold uppercase">
                                    <i class="fa-solid fa-network-wired text-sky-400 mr-1"></i> Stack Trace
                                </span>
                                <button onclick="navigator.clipboard.writeText(document.getElementById('trace-text-{{ $log['id'] }}').innerText); alert('Stack trace copied!');" class="text-[11px] font-mono text-sky-400 hover:underline">
                                    <i class="fa-regular fa-copy"></i> Copy Trace
                                </button>
                            </div>
                            <pre id="trace-text-{{ $log['id'] }}" class="font-mono text-[11px] text-slate-300 overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-96 overflow-y-auto">{{ $log['trace'] }}</pre>
                        </div>
                    @endif

                </div>
            @empty
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-3xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">No Matching Log Entries</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                        @if($filterLevel !== 'ALL' || !empty($searchQuery))
                            No logs found matching your filter criteria. Try resetting the search or filters.
                        @else
                            The Laravel log file is empty. Everything is running cleanly without exceptions.
                        @endif
                    </p>
                    @if($filterLevel !== 'ALL' || !empty($searchQuery))
                        <div class="mt-4">
                            <a href="{{ route('admin.logs.index', ['file' => $selectedFile]) }}" class="px-4 py-2 bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs rounded-xl transition-all inline-block shadow-sm">
                                Reset Filters
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>
    @endif

</div>
@endsection
