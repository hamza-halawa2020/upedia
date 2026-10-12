<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$database = 'upedia_full_migration_verification';
$connection = [
    'driver' => 'mysql', 'url' => null, 'host' => '127.0.0.1', 'port' => 33307,
    'database' => 'upedia_migration_verification', 'username' => 'root',
    'password' => 'local-verification-only-20261012', 'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci', 'prefix' => '', 'strict' => true,
];
config(['database.default' => 'mysql', 'database.connections' => ['mysql' => $connection],
    'cache.default' => 'array', 'session.driver' => 'array', 'queue.default' => 'sync',
    'broadcasting.default' => 'log', 'telescope.storage.database.connection' => 'mysql']);
DB::purge('mysql');
if (DB::selectOne('SELECT DATABASE() as name')->name !== 'upedia_migration_verification'
    || ! Schema::hasTable('verification_marker')) {
    throw new RuntimeException('Disposable container verification marker missing.');
}
DB::statement('CREATE DATABASE IF NOT EXISTS `upedia_full_migration_verification` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
config(['database.connections.mysql.database' => $database]);
DB::purge('mysql');
if (DB::selectOne('SELECT DATABASE() as name')->name !== $database) {
    throw new RuntimeException('Unexpected database.');
}
if (Schema::hasTable('verification_marker')) {
    if (! in_array('--reset', $argv, true)) {
        throw new RuntimeException('Use --reset only for this disposable schema.');
    }
    Schema::dropAllTables();
} elseif (count(Schema::getTables()) > 0) {
    throw new RuntimeException('Refusing an unmarked nonempty database.');
}
Schema::create('verification_marker', fn ($table) => $table->id());
Http::fake(fn () => Http::response([], 503));
Mail::fake();
Notification::fake();
try {
    Artisan::call('migrate', ['--force' => true]);
    echo 'PASS: all '.DB::table('migrations')->count()." migrations on isolated MySQL.\n";
    if (in_array('--seed', $argv, true)) {
        Artisan::call('db:seed', ['--force' => true]);
        echo "PASS: DatabaseSeeder on isolated MySQL.\n";
    }
} catch (Throwable $exception) {
    echo Artisan::output();
    fwrite(STDERR, 'FAIL: '.$exception->getMessage()."\n");
    exit(1);
} finally {
    DB::disconnect('mysql');
}
