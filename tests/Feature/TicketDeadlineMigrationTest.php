<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TicketDeadlineMigrationTest extends TestCase
{
    public function test_migration_keeps_legacy_values_and_round_trips_new_deadlines(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); $table->time('resolution_time')->nullable();
        });
        DB::table('tickets')->insert(['id' => 1, 'resolution_time' => '12:30:00']);
        $migration = require database_path('migrations/2026_10_12_000001_preserve_legacy_ticket_time_and_add_datetime_deadline.php');
        $migration->up();
        $this->assertDatabaseHas('tickets', ['id' => 1, 'legacy_resolution_time' => '12:30:00', 'resolution_time' => null]);
        DB::table('tickets')->where('id', 1)->update(['resolution_time' => '2026-10-12 12:30:00']);
        $migration->down();
        $this->assertDatabaseHas('tickets', ['id' => 1, 'resolution_time' => '12:30:00', 'reconstructed_resolution_time' => '2026-10-12 12:30:00']);
        $migration->up();
        $this->assertDatabaseHas('tickets', ['id' => 1, 'resolution_time' => '2026-10-12 12:30:00']);
    }
}
