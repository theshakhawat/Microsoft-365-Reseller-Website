@extends('layouts.admin.admin')

@section('title', 'Queue & Background Jobs Monitor - Admin Control Center')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <span>Queue & Background Jobs</span>
        <span class="text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2 py-0.5 rounded-full">
            {{ strtoupper($queueDriver) }}
        </span>
    </span>
@endsection

@section('content')
<div class="space-y-6">

    <!-- ================================================================= -->
    <!-- 1. HEADER BANNER & ACTION TOOLBAR                                 -->
    <!-- ================================================================= -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-xs">
        <div class="space-y-1.5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-[11px] font-black uppercase tracking-wider bg-[#0067b8] text-white px-2.5 py-0.5 rounded-md flex items-center gap-1.5">
                    <i class="fa-solid fa-gears text-xs"></i>
                    <span>Laravel Queue Monitor</span>
                </span>
                
                <!-- Live Realtime Pulse Badge -->
                <div id="live-status-pill" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span class="font-extrabold">LIVE SYNC ACTIVE</span>
                    <span id="live-time-indicator" class="text-[10px] opacity-75 font-mono ml-1">{{ now()->format('h:i:s A') }}</span>
                </div>

                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                    Driver: <code class="font-mono text-slate-800 dark:text-slate-200 font-bold">{{ $queueDriver }}</code>
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                Background Queue & Worker Monitor
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-2xl">
                Real-time tracking of pending, currently running, finished and failed background worker tasks.
            </p>
        </div>

        <!-- Global Action Controls -->
        <div class="flex flex-wrap items-center gap-2.5 shrink-0">

            <!-- Toggle Auto-Refresh Button -->
            <button type="button" id="btn-toggle-live" onclick="toggleLiveSync()" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer" title="Toggle automatic 2.5s polling">
                <i id="live-sync-icon" class="fa-solid fa-pause text-xs text-amber-500"></i>
                <span id="live-sync-text">Pause Live</span>
            </button>

            @if($failedCount > 0)
                <!-- Retry All Failed -->
                <form action="{{ route('admin.queue.retry-all') }}" method="POST" onsubmit="return confirm('Retry all {{ $failedCount }} failed jobs?');" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 transition-all shadow-sm active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        <span>Retry All Failed</span>
                    </button>
                </form>

                <!-- Flush All Failed -->
                <form action="{{ route('admin.queue.flush-failed') }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently flush all failed jobs?');" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-950/50 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/60 font-bold text-xs flex items-center gap-1.5 transition-all cursor-pointer">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                        <span>Flush Failed</span>
                    </button>
                </form>
            @endif

            <!-- Manual Refresh Button -->
            <button type="button" onclick="fetchLiveQueueMetrics(true)" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors cursor-pointer">
                <i class="fa-solid fa-sync text-xs"></i>
                <span>Refresh Now</span>
            </button>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 2. QUEUE STATS KPI CARDS                                          -->
    <!-- ================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Stat 1: Pending Jobs -->
        <a href="{{ route('admin.queue.index', ['tab' => 'pending']) }}" class="p-5 rounded-3xl border transition-all {{ $activeTab === 'pending' ? 'bg-sky-50 dark:bg-sky-950/30 border-[#0067b8] dark:border-sky-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 hover:border-slate-300' }}">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Pending in Queue</p>
                <div class="w-10 h-10 rounded-2xl bg-sky-100 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <p id="kpi-pending-count" class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $totalPending }}</p>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                Waiting for worker processing
            </p>
        </a>

        <!-- Stat 2: Currently Running -->
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Currently Running</p>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                    <i id="kpi-running-spinner" class="fa-solid fa-spinner {{ $runningCount > 0 ? 'fa-spin' : '' }}"></i>
                </div>
            </div>
            <p id="kpi-running-count" class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $runningCount }}</p>
            <p id="kpi-running-sub" class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">
                Active worker instances
            </p>
        </div>

        <!-- Stat 3: Failed Jobs -->
        <a href="{{ route('admin.queue.index', ['tab' => 'failed']) }}" class="p-5 rounded-3xl border transition-all {{ $activeTab === 'failed' ? 'bg-red-50 dark:bg-red-950/30 border-red-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 hover:border-red-300' }}">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Failed Jobs</p>
                <div class="w-10 h-10 rounded-2xl bg-red-50 dark:bg-red-950/60 text-red-600 dark:text-red-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <p id="kpi-failed-count" class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $failedCount }}</p>
            <p id="kpi-failed-sub" class="text-[11px] {{ $failedCount > 0 ? 'text-red-600 dark:text-red-400 font-bold' : 'text-emerald-600 dark:text-emerald-400 font-semibold' }} mt-1">
                {{ $failedCount > 0 ? 'Action & retry required' : '0 errors logged' }}
            </p>
        </a>

        <!-- Stat 4: Last 10 Success Jobs -->
        <a href="{{ route('admin.queue.index', ['tab' => 'successful']) }}" class="p-5 rounded-3xl border transition-all {{ $activeTab === 'successful' ? 'bg-emerald-50 dark:bg-emerald-950/30 border-emerald-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 hover:border-emerald-300' }}">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Recent Success Jobs</p>
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <p id="kpi-success-count" class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $successCount }}</p>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">
                Completed jobs history (Last 10)
            </p>
        </a>

    </div>

    <!-- ================================================================= -->
    <!-- 3. TAB NAVIGATION BAR                                             -->
    <!-- ================================================================= -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200/90 dark:border-slate-800 pb-2">
        <!-- Tab 1: Pending & Running -->
        <a href="{{ route('admin.queue.index', ['tab' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'pending' ? 'bg-[#0067b8] text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-list-check"></i>
            <span>Pending & Running Jobs</span>
            <span id="tab-badge-pending" class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                {{ $totalPending }}
            </span>
        </a>

        <!-- Tab 2: Failed Jobs -->
        <a href="{{ route('admin.queue.index', ['tab' => 'failed']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'failed' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>Failed Jobs</span>
            <span id="tab-badge-failed" class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'failed' ? 'bg-white/20 text-white' : ($failedCount > 0 ? 'bg-red-100 dark:bg-red-950 text-red-600 font-bold' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300') }}">
                {{ $failedCount }}
            </span>
        </a>

        <!-- Tab 3: Last 10 Success Jobs -->
        <a href="{{ route('admin.queue.index', ['tab' => 'successful']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'successful' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-circle-check"></i>
            <span>Last 10 Success Jobs</span>
            <span id="tab-badge-success" class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'successful' ? 'bg-white/20 text-white' : 'bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold' }}">
                {{ $successCount }}
            </span>
        </a>

        <!-- Tab 4: Job Batches -->
        <a href="{{ route('admin.queue.index', ['tab' => 'batches']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'batches' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-layer-group"></i>
            <span>Job Batches</span>
            <span id="tab-badge-batches" class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'batches' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                {{ $batchesCount }}
            </span>
        </a>
    </div>

    <!-- ================================================================= -->
    <!-- 4. TAB CONTENTS                                                   -->
    <!-- ================================================================= -->

    <!-- ------------------------------------------------------------- -->
    <!-- TAB 1: PENDING & RUNNING JOBS                                 -->
    <!-- ------------------------------------------------------------- -->
    @if($activeTab === 'pending')
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px] bg-slate-50/50 dark:bg-slate-800/30">
                            <th class="py-3.5 px-5">Job ID</th>
                            <th class="py-3.5 px-4">Job Class / Action</th>
                            <th class="py-3.5 px-4">Queue</th>
                            <th class="py-3.5 px-4">Attempts</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Queued At</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pending-jobs-tbody" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($pendingJobs as $job)
                            <tr id="job-row-{{ $job['id'] }}" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-slate-900 dark:text-white">
                                    #{{ $job['id'] }}
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-extrabold text-slate-900 dark:text-white text-xs">{{ $job['short_name'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-mono truncate max-w-xs">{{ $job['display_name'] }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $job['queue'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-bold">
                                    {{ $job['attempts'] }}
                                </td>
                                <td class="py-4 px-4">
                                    @if($job['is_reserved'])
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Running</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Queued</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-mono text-slate-500 dark:text-slate-400 text-[11px]">
                                    {{ $job['created_at'] }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('job-payload-{{ $job['id'] }}').classList.toggle('hidden');" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs cursor-pointer" title="Inspect payload">
                                            <i class="fa-solid fa-code text-[10px]"></i>
                                        </button>
                                        <form action="{{ route('admin.queue.pending.destroy', $job['id']) }}" method="POST" onsubmit="return confirm('Delete this job from queue?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-950/50 text-red-600 dark:text-red-400 font-bold text-xs cursor-pointer" title="Cancel & Delete">
                                                <i class="fa-regular fa-trash-can text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Collapsible Payload Row -->
                            <tr id="job-payload-{{ $job['id'] }}" class="hidden bg-slate-950 text-slate-300">
                                <td colspan="7" class="p-4 font-mono text-[11px]">
                                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-800">
                                        <span class="font-bold uppercase text-sky-400">Job Payload (#{{ $job['id'] }})</span>
                                        <span class="text-slate-500 text-[10px]">Available At: {{ $job['available_at'] }}</span>
                                    </div>
                                    <pre class="overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-48">{{ json_encode(json_decode($job['payload_raw']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr id="pending-empty-row">
                                <td colspan="7" class="py-14 text-center text-slate-400">
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                                        <i class="fa-solid fa-check-double"></i>
                                    </div>
                                    <p class="font-extrabold text-slate-700 dark:text-slate-300 text-sm">Queue is Clean & Idle</p>
                                    <p class="text-xs text-slate-400 mt-0.5">There are no pending jobs waiting for worker execution.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pendingJobs instanceof \Illuminate\Pagination\LengthAwarePaginator && $pendingJobs->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $pendingJobs->appends(['tab' => 'pending'])->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- ------------------------------------------------------------- -->
    <!-- TAB 2: FAILED JOBS                                            -->
    <!-- ------------------------------------------------------------- -->
    @if($activeTab === 'failed')
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px] bg-slate-50/50 dark:bg-slate-800/30">
                            <th class="py-3.5 px-5">ID</th>
                            <th class="py-3.5 px-4">Job Class</th>
                            <th class="py-3.5 px-4">Queue</th>
                            <th class="py-3.5 px-4">Error Exception</th>
                            <th class="py-3.5 px-4">Failed At</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($failedJobs as $job)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-slate-900 dark:text-white">
                                    #{{ $job['id'] }}
                                </td>
                                <td class="py-4 px-4">
                                    <p class="font-extrabold text-red-600 dark:text-red-400 text-xs">{{ $job['short_name'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-mono truncate max-w-xs">{{ $job['display_name'] }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $job['queue'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 max-w-sm">
                                    <p class="font-mono text-xs text-red-700 dark:text-red-400 font-semibold line-clamp-2 leading-relaxed">
                                        {{ $job['first_error'] }}
                                    </p>
                                </td>
                                <td class="py-4 px-4 font-mono text-slate-500 dark:text-slate-400 text-[11px] whitespace-nowrap">
                                    {{ $job['failed_at'] }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Toggle Exception Trace -->
                                        <button type="button" onclick="document.getElementById('failed-trace-{{ $job['id'] }}').classList.toggle('hidden');" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs cursor-pointer" title="View Exception Trace">
                                            <i class="fa-solid fa-code text-xs"></i>
                                        </button>

                                        <!-- Retry Job -->
                                        <form action="{{ route('admin.queue.failed.retry', $job['id']) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs inline-flex items-center gap-1 cursor-pointer shadow-xs" title="Retry this job">
                                                <i class="fa-solid fa-rotate-right text-[10px]"></i>
                                                <span>Retry</span>
                                            </button>
                                        </form>

                                        <!-- Delete Failed Job -->
                                        <form action="{{ route('admin.queue.failed.destroy', $job['id']) }}" method="POST" onsubmit="return confirm('Delete this failed job record?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-950/50 text-red-600 dark:text-red-400 font-bold text-xs cursor-pointer" title="Delete record">
                                                <i class="fa-regular fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Collapsible Exception Trace Row -->
                            <tr id="failed-trace-{{ $job['id'] }}" class="hidden bg-slate-950 text-slate-300">
                                <td colspan="6" class="p-5 font-mono text-[11px]">
                                    <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-800">
                                        <span class="font-bold uppercase text-red-400">Exception Stack Trace (#{{ $job['id'] }})</span>
                                        <button onclick="navigator.clipboard.writeText(document.getElementById('trace-box-{{ $job['id'] }}').innerText); alert('Trace copied!');" class="text-xs text-sky-400 hover:underline">
                                            <i class="fa-regular fa-copy mr-1"></i> Copy Trace
                                        </button>
                                    </div>
                                    <pre id="trace-box-{{ $job['id'] }}" class="overflow-x-auto whitespace-pre-wrap leading-relaxed max-h-72 overflow-y-auto text-red-300/90">{{ $job['exception'] }}</pre>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center text-slate-400">
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                    <p class="font-extrabold text-slate-700 dark:text-slate-300 text-sm">No Failed Jobs</p>
                                    <p class="text-xs text-slate-400 mt-0.5">All background queue executions have succeeded without unhandled errors.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($failedJobs instanceof \Illuminate\Pagination\LengthAwarePaginator && $failedJobs->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $failedJobs->appends(['tab' => 'failed'])->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- ------------------------------------------------------------- -->
    <!-- TAB 3: LAST 10 SUCCESSFUL JOBS                                -->
    <!-- ------------------------------------------------------------- -->
    @if($activeTab === 'successful')
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>Last 10 Processed Successful Jobs</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Automatically recorded upon successful worker execution cycle.</p>
                </div>
                <span class="text-xs font-mono font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                    {{ count($successfulJobs) }} Recorded
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px] bg-slate-50/50 dark:bg-slate-800/30">
                            <th class="py-3.5 px-5">Job Class / Action</th>
                            <th class="py-3.5 px-4">Queue</th>
                            <th class="py-3.5 px-4">Connection</th>
                            <th class="py-3.5 px-4">Attempts</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-5 text-right">Processed At</th>
                        </tr>
                    </thead>
                    <tbody id="successful-jobs-tbody" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($successfulJobs as $job)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-slate-900 dark:text-white text-xs">{{ $job['name'] ?? 'Job' }}</p>
                                            <p class="text-[10px] text-slate-400 font-mono truncate max-w-sm">{{ $job['full_name'] ?? ($job['name'] ?? 'Queue Job') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $job['queue'] ?? 'default' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-mono text-[11px] text-slate-500 dark:text-slate-400">
                                    {{ $job['connection'] ?? 'database' }}
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                                    {{ $job['attempts'] ?? 1 }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i>
                                        <span>Completed</span>
                                    </span>
                                </td>
                                <td class="py-4 px-5 font-mono text-slate-500 dark:text-slate-400 text-right text-[11px]">
                                    {{ $job['processed_at'] ?? now()->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr id="success-empty-row">
                                <td colspan="6" class="py-14 text-center text-slate-400">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </div>
                                    <p class="font-extrabold text-slate-700 dark:text-slate-300 text-sm">No Successful Jobs Recorded Yet</p>
                                    <p class="text-xs text-slate-400 mt-0.5">As queue workers finish jobs, the last 10 successful executions will appear here in real-time.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ------------------------------------------------------------- -->
    <!-- TAB 4: JOB BATCHES                                            -->
    <!-- ------------------------------------------------------------- -->
    @if($activeTab === 'batches')
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px] bg-slate-50/50 dark:bg-slate-800/30">
                            <th class="py-3.5 px-5">Batch ID</th>
                            <th class="py-3.5 px-4">Batch Name</th>
                            <th class="py-3.5 px-4">Total Jobs</th>
                            <th class="py-3.5 px-4">Pending</th>
                            <th class="py-3.5 px-4">Failed</th>
                            <th class="py-3.5 px-4">Progress</th>
                            <th class="py-3.5 px-5 text-right">Finished At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($batches as $batch)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-5 font-mono font-bold text-slate-900 dark:text-white">
                                    {{ substr($batch['id'], 0, 8) }}...
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                                    {{ $batch['name'] }}
                                </td>
                                <td class="py-4 px-4 font-mono font-bold">
                                    {{ $batch['total_jobs'] }}
                                </td>
                                <td class="py-4 px-4 font-mono">
                                    {{ $batch['pending_jobs'] }}
                                </td>
                                <td class="py-4 px-4 font-mono {{ $batch['failed_jobs'] > 0 ? 'text-red-500 font-bold' : '' }}">
                                    {{ $batch['failed_jobs'] }}
                                </td>
                                <td class="py-4 px-4 w-40">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                                            <div class="bg-[#0067b8] h-2 rounded-full" style="width: {{ $batch['progress'] }}%;"></div>
                                        </div>
                                        <span class="text-[10px] font-bold font-mono">{{ $batch['progress'] }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-mono text-slate-500 dark:text-slate-400 text-right">
                                    {{ $batch['finished_at'] ?: 'In Progress' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-14 text-center text-slate-400">
                                    <p class="font-bold text-slate-700 dark:text-slate-300 text-sm">No Batches Found</p>
                                    <p class="text-xs text-slate-400 mt-0.5">No bulk job batches have been dispatched.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($batches instanceof \Illuminate\Pagination\LengthAwarePaginator && $batches->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $batches->appends(['tab' => 'batches'])->links() }}
                </div>
            @endif
        </div>
    @endif

</div>

<!-- ================================================================= -->
<!-- 5. REAL-TIME LIVE POLLING & AUTO-UPDATE SCRIPT                    -->
<!-- ================================================================= -->
<script>
    let isLiveSyncActive = true;
    let liveSyncTimer = null;
    const currentTab = "{{ $activeTab }}";
    const metricsEndpoint = "{{ route('admin.queue.metrics') }}";

    // Initialize real-time updates
    document.addEventListener('DOMContentLoaded', function() {
        startLiveSync();
    });

    function startLiveSync() {
        if (liveSyncTimer) clearInterval(liveSyncTimer);
        liveSyncTimer = setInterval(() => {
            if (isLiveSyncActive) {
                fetchLiveQueueMetrics(false);
            }
        }, 2500);
    }

    function toggleLiveSync() {
        isLiveSyncActive = !isLiveSyncActive;
        const icon = document.getElementById('live-sync-icon');
        const text = document.getElementById('live-sync-text');
        const pill = document.getElementById('live-status-pill');

        if (isLiveSyncActive) {
            icon.className = 'fa-solid fa-pause text-xs text-amber-500';
            text.innerText = 'Pause Live';
            if (pill) {
                pill.className = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800';
            }
            fetchLiveQueueMetrics(true);
        } else {
            icon.className = 'fa-solid fa-play text-xs text-emerald-500';
            text.innerText = 'Resume Live';
            if (pill) {
                pill.className = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700';
            }
        }
    }

    let previousPendingCount = {{ $totalPending }};
    let previousSuccessCount = {{ $successCount }};

    function fetchLiveQueueMetrics(isManual = false) {
        fetch(metricsEndpoint, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // 1. Update live timestamp
            const timeIndicator = document.getElementById('live-time-indicator');
            if (timeIndicator && data.timestamp) {
                timeIndicator.innerText = data.timestamp;
            }

            // 2. Update KPI numbers
            const kpiPending = document.getElementById('kpi-pending-count');
            if (kpiPending) kpiPending.innerText = data.total_pending;

            const kpiRunning = document.getElementById('kpi-running-count');
            if (kpiRunning) kpiRunning.innerText = data.running_count;

            const runningSpinner = document.getElementById('kpi-running-spinner');
            if (runningSpinner) {
                if (data.running_count > 0) {
                    runningSpinner.classList.add('fa-spin');
                } else {
                    runningSpinner.classList.remove('fa-spin');
                }
            }

            const kpiFailed = document.getElementById('kpi-failed-count');
            if (kpiFailed) kpiFailed.innerText = data.failed_count;

            const kpiSuccess = document.getElementById('kpi-success-count');
            if (kpiSuccess) kpiSuccess.innerText = data.success_count;

            // 3. Update tab badges
            const tabPending = document.getElementById('tab-badge-pending');
            if (tabPending) tabPending.innerText = data.total_pending;

            const tabFailed = document.getElementById('tab-badge-failed');
            if (tabFailed) tabFailed.innerText = data.failed_count;

            const tabSuccess = document.getElementById('tab-badge-success');
            if (tabSuccess) tabSuccess.innerText = data.success_count;

            const tabBatches = document.getElementById('tab-badge-batches');
            if (tabBatches) tabBatches.innerText = data.batches_count;

            // 4. Check for newly completed jobs to give visual feedback
            if (data.success_count > previousSuccessCount) {
                showQueueToast('A background queue job has finished successfully!', 'success');
            }
            previousSuccessCount = data.success_count;
            previousPendingCount = data.total_pending;

            // 5. Update active tab tables dynamically
            if (currentTab === 'pending') {
                updatePendingTable(data.pending_jobs || []);
            } else if (currentTab === 'successful') {
                updateSuccessTable(data.successful_jobs || []);
            }
        })
        .catch(err => {
            console.error('Queue metrics sync error:', err);
        });
    }

    function updatePendingTable(jobs) {
        const tbody = document.getElementById('pending-jobs-tbody');
        if (!tbody) return;

        if (jobs.length === 0) {
            tbody.innerHTML = `
                <tr id="pending-empty-row">
                    <td colspan="7" class="py-14 text-center text-slate-400">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <p class="font-extrabold text-slate-700 dark:text-slate-300 text-sm">Queue is Clean & Idle</p>
                        <p class="text-xs text-slate-400 mt-0.5">There are no pending jobs waiting for worker execution.</p>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        jobs.forEach(job => {
            const statusBadge = job.is_reserved ? `
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 animate-pulse">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Running</span>
                </span>
            ` : `
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span>Queued</span>
                </span>
            `;

            html += `
                <tr id="job-row-${job.id}" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5 font-mono font-bold text-slate-900 dark:text-white">
                        #${job.id}
                    </td>
                    <td class="py-4 px-4">
                        <p class="font-extrabold text-slate-900 dark:text-white text-xs">${escapeHtml(job.short_name)}</p>
                        <p class="text-[10px] text-slate-400 font-mono truncate max-w-xs">${escapeHtml(job.display_name)}</p>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            ${escapeHtml(job.queue)}
                        </span>
                    </td>
                    <td class="py-4 px-4 font-bold">
                        ${job.attempts}
                    </td>
                    <td class="py-4 px-4">
                        ${statusBadge}
                    </td>
                    <td class="py-4 px-4 font-mono text-slate-500 dark:text-slate-400 text-[11px]">
                        ${job.queued_at || ''}
                    </td>
                    <td class="py-4 px-5 text-right">
                        <form action="/admin/queue-jobs/pending/${job.id}" method="POST" onsubmit="return confirm('Delete this job from queue?');" class="inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-950/50 text-red-600 dark:text-red-400 font-bold text-xs cursor-pointer" title="Cancel & Delete">
                                <i class="fa-regular fa-trash-can text-[10px]"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    function updateSuccessTable(jobs) {
        const tbody = document.getElementById('successful-jobs-tbody');
        if (!tbody) return;

        if (jobs.length === 0) {
            tbody.innerHTML = `
                <tr id="success-empty-row">
                    <td colspan="6" class="py-14 text-center text-slate-400">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <p class="font-extrabold text-slate-700 dark:text-slate-300 text-sm">No Successful Jobs Recorded Yet</p>
                        <p class="text-xs text-slate-400 mt-0.5">As queue workers finish jobs, the last 10 successful executions will appear here in real-time.</p>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        jobs.forEach(job => {
            html += `
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-900 dark:text-white text-xs">${escapeHtml(job.name || 'Job')}</p>
                                <p class="text-[10px] text-slate-400 font-mono truncate max-w-sm">${escapeHtml(job.full_name || job.name || 'Queue Job')}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-0.5 rounded-md font-mono text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            ${escapeHtml(job.queue || 'default')}
                        </span>
                    </td>
                    <td class="py-4 px-4 font-mono text-[11px] text-slate-500 dark:text-slate-400">
                        ${escapeHtml(job.connection || 'database')}
                    </td>
                    <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">
                        ${job.attempts || 1}
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            <span>Completed</span>
                        </span>
                    </td>
                    <td class="py-4 px-5 font-mono text-slate-500 dark:text-slate-400 text-right text-[11px]">
                        ${escapeHtml(job.processed_at || '')}
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    function escapeHtml(string) {
        if (!string) return '';
        return String(string)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showQueueToast(message, type = 'info') {
        const container = document.getElementById('toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl border text-xs font-bold transition-all transform duration-300 translate-y-2 opacity-0 ${
            type === 'success' 
                ? 'bg-emerald-900 text-emerald-100 border-emerald-700' 
                : 'bg-slate-900 text-slate-100 border-slate-700'
        }`;
        toast.innerHTML = `
            <i class="fa-solid fa-circle-check text-emerald-400"></i>
            <span>${message}</span>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    function createToastContainer() {
        const div = document.createElement('div');
        div.id = 'toast-container';
        div.className = 'fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none';
        document.body.appendChild(div);
        return div;
    }
</script>
@endsection
