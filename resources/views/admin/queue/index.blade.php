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
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400">
                    Connection: <code class="font-mono text-slate-800 dark:text-slate-200 font-bold">{{ $queueDriver }}</code>
                </span>
                @if($runningCount > 0)
                    <span class="text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ $runningCount }} Running Job(s)
                    </span>
                @endif
            </div>
            <h2 class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                Background Processes & Worker Jobs
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-2xl">
                Monitor asynchronous background queues, view waiting jobs, and retry or clear failed exception jobs.
            </p>
        </div>

        <!-- Global Action Controls -->
        <div class="flex flex-wrap items-center gap-2.5 shrink-0">

            @if($failedCount > 0)
                <!-- Retry All Failed -->
                <form action="{{ route('admin.queue.retry-all') }}" method="POST" onsubmit="return confirm('Retry all {{ $failedCount }} failed jobs?');" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-1.5 transition-all shadow-sm active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        <span>Retry All ({{ $failedCount }})</span>
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

            <!-- Refresh Button -->
            <a href="{{ request()->fullUrl() }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-sync text-xs"></i>
                <span>Refresh</span>
            </a>
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
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $totalPending }}</p>
            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold mt-1">
                Waiting for worker processing
            </p>
        </a>

        <!-- Stat 2: Currently Running -->
        <div class="p-5 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xs">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Currently Running</p>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-spinner {{ $runningCount > 0 ? 'fa-spin' : '' }}"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $runningCount }}</p>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">
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
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $failedCount }}</p>
            @if($failedCount > 0)
                <p class="text-[11px] text-red-600 dark:text-red-400 font-bold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-circle-exclamation text-[9px]"></i> Retry required
                </p>
            @else
                <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">
                    0 errors logged
                </p>
            @endif
        </a>

        <!-- Stat 4: Batches -->
        <a href="{{ route('admin.queue.index', ['tab' => 'batches']) }}" class="p-5 rounded-3xl border transition-all {{ $activeTab === 'batches' ? 'bg-purple-50 dark:bg-purple-950/30 border-purple-500 shadow-sm' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800 hover:border-purple-300' }}">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Job Batches</p>
                <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $batchesCount }}</p>
            <p class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold mt-1">
                Batch processing sets
            </p>
        </a>

    </div>

    <!-- ================================================================= -->
    <!-- 3. TAB NAVIGATION BAR                                             -->
    <!-- ================================================================= -->
    <div class="flex items-center gap-2 border-b border-slate-200/90 dark:border-slate-800 pb-2">
        <a href="{{ route('admin.queue.index', ['tab' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'pending' ? 'bg-[#0067b8] text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-list-check"></i>
            <span>Pending & Running Jobs</span>
            <span class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                {{ $totalPending }}
            </span>
        </a>

        <a href="{{ route('admin.queue.index', ['tab' => 'failed']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'failed' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>Failed Jobs</span>
            <span class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'failed' ? 'bg-white/20 text-white' : ($failedCount > 0 ? 'bg-red-100 dark:bg-red-950 text-red-600' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300') }}">
                {{ $failedCount }}
            </span>
        </a>

        <a href="{{ route('admin.queue.index', ['tab' => 'batches']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'batches' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <i class="fa-solid fa-layer-group"></i>
            <span>Job Batches</span>
            <span class="px-2 py-0.5 text-[10px] rounded-full {{ $activeTab === 'batches' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
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
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($pendingJobs as $job)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
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
                            <tr>
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
    <!-- TAB 3: JOB BATCHES                                            -->
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
@endsection
