<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminQueueController extends Controller
{
    /**
     * Display background queue jobs, failed jobs, batches, and success history.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'pending'); // pending, failed, successful, batches

        // 1. Pending & Running Jobs
        $runningCount = 0;
        $pendingCount = 0;
        $totalPending = 0;

        if (Schema::hasTable('jobs')) {
            $rawJobs = DB::table('jobs')->orderBy('id', 'desc')->paginate(20, ['*'], 'pending_page');

            $pendingJobs = $rawJobs->through(function ($job) use (&$runningCount, &$pendingCount) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
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
        }

        // 2. Failed Jobs
        $failedJobs = collect();
        $failedCount = 0;

        if (Schema::hasTable('failed_jobs')) {
            $rawFailed = DB::table('failed_jobs')->orderBy('id', 'desc')->paginate(20, ['*'], 'failed_page');

            $failedJobs = $rawFailed->through(function ($job) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
                $shortName = class_basename($displayName);

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
        }

        // 3. Batches
        $batches = collect();
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
        }

        // 4. Last 10 Successful Jobs
        $successfulJobs = Cache::get('recent_successful_jobs', []);
        $successCount = count($successfulJobs);

        $queueDriver = config('queue.default', 'database');

        return view('admin.queue.index', compact(
            'activeTab',
            'pendingJobs',
            'failedJobs',
            'batches',
            'successfulJobs',
            'totalPending',
            'runningCount',
            'failedCount',
            'batchesCount',
            'successCount',
            'queueDriver'
        ));
    }

    /**
     * Get real-time queue metrics and job items for live dashboard updates.
     */
    public function metrics(): JsonResponse
    {
        $totalPending = 0;
        $runningCount = 0;
        $pendingItems = [];

        if (Schema::hasTable('jobs')) {
            $totalPending = DB::table('jobs')->count();
            $runningCount = DB::table('jobs')->whereNotNull('reserved_at')->count();

            $raw = DB::table('jobs')->orderBy('id', 'desc')->take(20)->get();
            foreach ($raw as $job) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
                $isReserved = !empty($job->reserved_at);

                $pendingItems[] = [
                    'id'           => $job->id,
                    'queue'        => $job->queue,
                    'display_name' => $displayName,
                    'short_name'   => class_basename($displayName),
                    'attempts'     => $job->attempts,
                    'is_reserved'  => $isReserved,
                    'status'       => $isReserved ? 'Running' : 'Pending',
                    'queued_at'    => date('Y-m-d H:i:s', $job->created_at),
                ];
            }
        }

        $failedCount = 0;
        $failedItems = [];
        if (Schema::hasTable('failed_jobs')) {
            $failedCount = DB::table('failed_jobs')->count();
            $rawFailed = DB::table('failed_jobs')->orderBy('id', 'desc')->take(20)->get();
            foreach ($rawFailed as $job) {
                $payload = json_decode($job->payload, true) ?: [];
                $displayName = $payload['displayName'] ?? ($payload['data']['commandName'] ?? 'Unknown Job');
                $lines = explode("\n", $job->exception);

                $failedItems[] = [
                    'id'           => $job->id,
                    'uuid'         => $job->uuid,
                    'queue'        => $job->queue,
                    'short_name'   => class_basename($displayName),
                    'first_error'  => $lines[0] ?? 'Exception',
                    'failed_at'    => $job->failed_at,
                ];
            }
        }

        $batchesCount = Schema::hasTable('job_batches') ? DB::table('job_batches')->count() : 0;
        $successfulJobs = Cache::get('recent_successful_jobs', []);
        $successCount = count($successfulJobs);

        return response()->json([
            'total_pending'   => $totalPending,
            'running_count'   => $runningCount,
            'failed_count'    => $failedCount,
            'batches_count'   => $batchesCount,
            'success_count'   => $successCount,
            'pending_jobs'    => $pendingItems,
            'failed_jobs'     => $failedItems,
            'successful_jobs' => $successfulJobs,
            'timestamp'       => now()->format('h:i:s A'),
        ]);
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
     * Retry a specific failed job: Move it from failed_jobs back to jobs (pending queue).
     */
    public function retryJob(string $id): RedirectResponse
    {
        try {
            $failedJob = DB::table('failed_jobs')
                ->where('id', $id)
                ->orWhere('uuid', $id)
                ->first();

            if (!$failedJob) {
                return back()->with('error', "Failed job #{$id} not found in the database.");
            }

            $jobId = $failedJob->id;
            $queueName = $failedJob->queue ?: 'default';

            // Insert into active pending jobs table
            DB::table('jobs')->insert([
                'queue'        => $queueName,
                'payload'      => $failedJob->payload,
                'attempts'     => 0,
                'reserved_at'  => null,
                'available_at' => time(),
                'created_at'   => time(),
            ]);

            // Remove from failed_jobs table
            DB::table('failed_jobs')->where('id', $jobId)->delete();

            return redirect()->route('admin.queue.index', ['tab' => 'pending'])
                ->with('success', "Failed job #{$jobId} has been moved to Pending & Running Queue. It will execute when worker starts.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to retry job: " . $e->getMessage());
        }
    }

    /**
     * Retry all failed jobs: Move all from failed_jobs to jobs (pending queue).
     */
    public function retryAll(): RedirectResponse
    {
        try {
            if (!Schema::hasTable('failed_jobs')) {
                return back()->with('info', 'No failed jobs table found.');
            }

            $failedJobs = DB::table('failed_jobs')->get();
            $count = $failedJobs->count();

            if ($count === 0) {
                return back()->with('info', 'There are no failed jobs to retry.');
            }

            foreach ($failedJobs as $job) {
                DB::table('jobs')->insert([
                    'queue'        => $job->queue ?: 'default',
                    'payload'      => $job->payload,
                    'attempts'     => 0,
                    'reserved_at'  => null,
                    'available_at' => time(),
                    'created_at'   => time(),
                ]);
            }

            DB::table('failed_jobs')->delete();

            return redirect()->route('admin.queue.index', ['tab' => 'pending'])
                ->with('success', "All {$count} failed jobs have been moved to Pending & Running Queue. They will execute when worker starts.");
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
            $failedJob = DB::table('failed_jobs')
                ->where('id', $id)
                ->orWhere('uuid', $id)
                ->first();

            if ($failedJob) {
                DB::table('failed_jobs')->where('id', $failedJob->id)->delete();
                return back()->with('success', "Failed job #{$failedJob->id} deleted successfully.");
            }

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
            if (Schema::hasTable('failed_jobs')) {
                DB::table('failed_jobs')->delete();
            } else {
                Artisan::call('queue:flush');
            }
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
