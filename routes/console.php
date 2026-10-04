<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily Midnight (12:00 AM) audit for expired subscriptions
Schedule::command('subscriptions:check-expired')
    ->dailyAt('00:00')
    ->runInBackground();

