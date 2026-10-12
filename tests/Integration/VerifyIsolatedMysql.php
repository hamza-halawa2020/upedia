<?php

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Reports\Queries\ReportCharts;
use Modules\IT\Reports\Queries\ReportResolution;
use Modules\IT\Tickets\Actions\SaveTicket;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$database = 'upedia_migration_verification';
config(['database.default' => 'mysql', 'database.connections.mysql' => [
    'driver' => 'mysql', 'url' => null, 'host' => '127.0.0.1', 'port' => 33307,
    'database' => $database, 'username' => 'root', 'password' => 'local-verification-only-20261012',
    'charset' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci', 'prefix' => '', 'strict' => true,
], 'cache.default' => 'array', 'session.driver' => 'array']);
DB::purge('mysql');
if (DB::selectOne('SELECT DATABASE() as name')->name !== $database) {
    throw new RuntimeException('Refusing to verify against an unexpected database.');
}
if (Schema::hasTable('verification_marker')) {
    if (! in_array('--reset', $argv, true)) {
        throw new RuntimeException('Verification already ran. Use --reset only for this disposable database.');
    }
    Schema::dropAllTables();
} elseif (count(Schema::getTables()) !== 0) {
    throw new RuntimeException('Refusing to modify a nonempty unmarked database.');
}
Schema::create('verification_marker', fn (Blueprint $table) => $table->id());
$assertions = 0;
$check = function (bool $condition, string $message) use (&$assertions): void {
    if (! $condition) {
        throw new RuntimeException($message);
    }
    $assertions++;
};
Schema::create('tickets', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('status');
    $table->time('resolution_time')->nullable();
    $table->integer('item_resolution_time')->nullable();
    $table->timestamp('closed_at')->nullable();
    $table->unsignedInteger('reopen_count')->default(0);
    $table->boolean('first_notification_sent')->default(false);
    $table->boolean('second_notification_sent')->default(false);
    $table->integer('remaining_time')->nullable();
    $table->timestamps();
    foreach (['ticket_priority_id', 'ticket_item_id', 'ticket_category_id', 'ticket_subcategory_id', 'requester_id', 'assigned_to', 'created_by'] as $field) {
        $table->unsignedBigInteger($field)->nullable();
    }
    $table->text('resolution_description')->nullable();
});
Schema::create('ticket_priorities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('sla_hours', 8, 2);
    $table->timestamps();
});
Schema::create('ticket_items', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->boolean('is_sla');
    $table->integer('resolution_time');
    $table->timestamps();
});
Schema::create('firebase_notification_configs', function (Blueprint $table) {
    $table->id();
    $table->integer('working_hour_start');
    $table->integer('working_hour_end');
});
Schema::create('ticket_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
});
Schema::create('sm_human_departments', function (Blueprint $table) {
    $table->id();
    $table->string('name');
});
Schema::create('sm_staffs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('department_id');
});
DB::table('ticket_priorities')->insert(['id' => 1, 'name' => 'High', 'sla_hours' => 2]);
DB::table('ticket_items')->insert(['id' => 1, 'name' => 'Network', 'is_sla' => true, 'resolution_time' => 30]);
DB::table('firebase_notification_configs')->insert(['working_hour_start' => 8, 'working_hour_end' => 16]);
DB::table('ticket_categories')->insert(['id' => 1, 'name' => 'Network']);
DB::table('sm_human_departments')->insert(['id' => 1, 'name' => 'IT']);
DB::table('sm_staffs')->insert(['id' => 1, 'department_id' => 1]);
DB::table('tickets')->insert(['id' => 1, 'title' => 'Legacy', 'status' => 'open',
    'resolution_time' => '11:00:00', 'ticket_priority_id' => 1, 'created_at' => '2026-10-12 10:00:00']);
$migration = require __DIR__.'/../../database/migrations/2026_10_12_000001_preserve_legacy_ticket_time_and_add_datetime_deadline.php';
$migration->up();
$column = DB::selectOne('SELECT DATA_TYPE as type FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?', [$database, 'tickets', 'resolution_time']);
$check($column->type === 'datetime', 'Deadline column is not DATETIME in MySQL.');
$check(DB::table('tickets')->value('legacy_resolution_time') === '11:00:00', 'Legacy TIME value was lost.');
Carbon::setTestNow(Carbon::parse('2026-10-12 10:00:00'));
try {
    $ticket = app(SaveTicket::class)->handle(['title' => 'SLA check', 'status' => 'open',
        'ticket_priority_id' => 1, 'ticket_item_id' => 1, 'ticket_category_id' => 1, 'requester_id' => 1], 1);
    $check($ticket->resolution_time === '2026-10-12 12:30:00', 'Two SLA hours plus thirty item minutes should finish at 12:30.');
    $check((int) $ticket->item_resolution_time === 150, 'Total SLA minutes are incorrect.');
    Artisan::call('it:tickets:rebuild-deadlines');
    $check(Ticket::find(1)->resolution_time === null, 'Dry-run reconstructed a deadline.');
    Artisan::call('it:tickets:rebuild-deadlines', ['--apply' => true]);
    $check(Ticket::find(1)->resolution_time === '2026-10-12 12:00:00', 'Reconstructed deadline did not use SLA hours.');
    $migration->down();
    $check(DB::table('tickets')->where('id', 1)->value('resolution_time') === '11:00:00', 'Rollback did not restore legacy time.');
    $migration->up();
    $check(Ticket::find(1)->resolution_time === '2026-10-12 12:00:00', 'Reapply lost reconstructed deadline.');
    DB::table('tickets')->where('id', $ticket->id)->update(['status' => 'closed', 'closed_at' => '2026-10-12 11:30:00']);
    $metrics = app(ReportResolution::class)->getResolutionMetrics(Carbon::parse('2026-10-12'), Carbon::parse('2026-10-12 23:59:59'));
    $check($metrics['average'] === '1h 30m', 'MySQL TIMESTAMPDIFF report calculation failed.');
    $charts = app(ReportCharts::class)->getChartData(Carbon::parse('2026-10-12'), Carbon::parse('2026-10-12 23:59:59'), 'day');
    $check((int) $charts['trend']['values']->sum() === 2, 'MySQL hourly chart calculation failed.');
    $check($charts['categories']['labels']->contains('Network'), 'Category chart aggregation failed.');
    echo "PASS: {$assertions} isolated MySQL assertions. Shared database untouched.\n";
} finally {
    Carbon::setTestNow();
    DB::disconnect('mysql');
}
