<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('sessions:detect-expired' , function () {
    $this->call(App\Console\Commands\DetectExpiredSessions::class);
})->everyThirtySeconds()
    ->withoutOverlapping();
