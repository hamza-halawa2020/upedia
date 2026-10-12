<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$queue = config('notifications.queue');
echo 'Configured broadcaster: '.config('broadcasting.default')."\n";
echo 'Configured queue connection: '.config('queue.default')."\n";
echo 'Pending notification jobs: '.DB::table('jobs')->where('queue', $queue)->count()."\n";
echo 'Failed notification jobs: '.DB::table('failed_jobs')->where('queue', $queue)->count()."\n";
