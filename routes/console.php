<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Purge archived facilities and stations older than 7 days
Schedule::command('archive:purge')
    ->daily()
    ->at('03:00')
    ->withoutOverlapping()
    ->runInBackground();
