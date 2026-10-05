<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dynamically apply database-driven SMTP & Mail configuration
        SmtpSetting::applyConfig();

        // Track last 10 successful background jobs
        Queue::after(function (JobProcessed $event) {
            try {
                $history = Cache::get('recent_successful_jobs', []);
                $jobName = class_basename($event->job->resolveName());
                $entry = [
                    'id'           => uniqid('succ_'),
                    'name'         => $jobName,
                    'full_name'    => $event->job->resolveName(),
                    'queue'        => $event->job->getQueue() ?: 'default',
                    'connection'   => $event->connectionName ?: 'database',
                    'attempts'     => $event->job->attempts(),
                    'processed_at' => now()->format('Y-m-d H:i:s'),
                    'time_ago'     => 'Just now',
                    'status'       => 'completed',
                ];
                array_unshift($history, $entry);
                $history = array_slice($history, 0, 10);
                Cache::put('recent_successful_jobs', $history, now()->addDays(7));
            } catch (\Throwable $e) {
                // Ignore tracking failures
            }
        });
    }
}
