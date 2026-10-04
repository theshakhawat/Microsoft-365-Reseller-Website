<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminQueueController extends Controller
{
    /**
     * Display background queue jobs, failed jobs, and batches.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'pending'); // pending, failed, batches

        // 1. Pending & Running Jobs
        $pendingJobs = [];
        $runningCount = 0;
        $pendingCount = 0;

        if (Schema::hasTable('jobs')) {
            $rawJobs = DB::table('jobs')->orderBy('id', 'desc')->paginate(20, ['*'], 'pending_page');
            
            $pendingJobs = $rawJobs->through(function ($job) use (&$runningCount, &$pendingCount) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
                
                // Shorten class name for cleaner display
                $shortName = class_basename($displayName);

                $isReserved = !empty($job->reserved_at);
                if ($isReserved) {
                    $runningCount++;
                } else {
                    $pendingCount++;
                }

                return [
                    'id'           => $job->id,
                    'queue'        => $job->queue,
                    'display_name' => $displayName,
                    'short_name'   => $shortName,
                    'attempts'     => $job->attempts,
                    'is_reserved'  => $isReserved,
                    'reserved_at'  => $job->reserved_at ? date('Y-m-d H:i:s', $job->reserved_at) : null,
                    'available_at' => date('Y-m-d H:i:s', $job->available_at),
                    'created_at'   => date('Y-m-d H:i:s', $job->created_at),
                    'payload_raw'  => $job->payload,
                ];
            });

            $totalPending = DB::table('jobs')->count();
            $runningCount = DB::table('jobs')->whereNotNull('reserved_at')->count();
        } else {
            $pendingJobs = collect();
            $totalPending = 0;
            $runningCount = 0;
        }

        // 2. Failed Jobs
        $failedJobs = [];
        $failedCount = 0;

        if (Schema::hasTable('failed_jobs')) {
            $rawFailed = DB::table('failed_jobs')->orderBy('id', 'desc')->paginate(20, ['*'], 'failed_page');
            
            $failedJobs = $rawFailed->through(function ($job) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
                $shortName = class_basename($displayName);

                // Extract error message from first line of exception
                $lines = explode("\n", $job->exception);
                $firstError = $lines[0] ?? 'Unknown Exception';

                return [
                    'id'           => $job->id,
                    'uuid'         => $job->uuid,
                    'connection'   => $job->connection,
                    'queue'        => $job->queue,
                    'display_name' => $displayName,
                    'short_name'   => $shortName,
                    'first_error'  => $firstError,
                    'exception'    => $job->exception,
                    'failed_at'    => $job->failed_at,
                    'payload_raw'  => $job->payload,
                ];
            });

            $failedCount = DB::table('failed_jobs')->count();
        } else {
            $failedJobs = collect();
            $failedCount = 0;
        }

        // 3. Batches
        $batches = [];
        $batchesCount = 0;

        if (Schema::hasTable('job_batches')) {
            $rawBatches = DB::table('job_batches')->orderBy('created_at', 'desc')->paginate(20, ['*'], 'batches_page');
            
            $batches = $rawBatches->through(function ($batch) {
                $progress = $batch->total_jobs > 0 
                    ? round((($batch->total_jobs - $batch->pending_jobs) / $batch->total_jobs) * 100) 
                    : 0;

                return [
                    'id'           => $batch->id,
                    'name'         => $batch->name,
                    'total_jobs'   => $batch->total_jobs,
                    'pending_jobs' => $batch->pending_jobs,
                    'failed_jobs'  => $batch->failed_jobs,
                    'progress'     => $progress,
                    'cancelled_at' => $batch->cancelled_at ? date('Y-m-d H:i:s', $batch->cancelled_at) : null,
                    'created_at'   => date('Y-m-d H:i:s', $batch->created_at),
                    'finished_at'  => $batch->finished_at ? date('Y-m-d H:i:s', $batch->finished_at) : null,
                ];
            });

            $batchesCount = DB::table('job_batches')->count();
        } else {
            $batches = collect();
            $batchesCount = 0;
        }

        $queueDriver = config('queue.default', 'database');

        return view('admin.queue.index', compact(
            'activeTab',
            'pendingJobs',
            'failedJobs',
            'batches',
            'totalPending',
            'runningCount',
            'failedCount',
            'batchesCount',
            'queueDriver'
        ));
    }

    /**
     * Restart all queue workers.
     */
    public function restartWorkers(): RedirectResponse
    {
        try {
            Artisan::call('queue:restart');
            return back()->with('success', 'Queue restart signal broadcasted. Background workers will reload fresh code on their next cycle.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to restart queue workers: ' . $e->getMessage());
        }
    }

    /**
     * Retry a specific failed job.
     */
    public function retryJob(string $id): RedirectResponse
    {
        try {
            Artisan::call('queue:retry', ['id' => [$id]]);
            return back()->with('success', "Failed job #{$id} has been pushed back onto the queue for execution.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to retry job: " . $e->getMessage());
        }
    }

    /**
     * Retry all failed jobs.
     */
    public function retryAll(): RedirectResponse
    {
        try {
            Artisan::call('queue:retry', ['id' => ['all']]);
            return back()->with('success', 'All failed jobs have been pushed back onto the queue for retry.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to retry all jobs: ' . $e->getMessage());
        }
    }

    /**
     * Delete / forget a specific failed job.
     */
    public function deleteFailedJob(string $id): RedirectResponse
    {
        try {
            Artisan::call('queue:forget', ['id' => $id]);
            return back()->with('success', "Failed job #{$id} deleted successfully.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to delete job: " . $e->getMessage());
        }
    }

    /**
     * Flush all failed jobs from database.
     */
    public function flushFailedJobs(): RedirectResponse
    {
        try {
            Artisan::call('queue:flush');
            return back()->with('success', 'All failed jobs have been cleared from database.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to flush failed jobs: ' . $e->getMessage());
        }
    }

    /**
     * Delete a pending job from the queue.
     */
    public function deletePendingJob(int $id): RedirectResponse
    {
        try {
            DB::table('jobs')->where('id', $id)->delete();
            return back()->with('success', "Pending job #{$id} was removed from the queue.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to remove pending job: " . $e->getMessage());
        }
    }
}
