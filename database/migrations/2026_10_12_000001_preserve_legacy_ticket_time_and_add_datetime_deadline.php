<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tickets', 'legacy_resolution_time')) {
            Schema::table('tickets', fn (Blueprint $table) => $table->renameColumn('resolution_time', 'legacy_resolution_time'));
        }
        if (! Schema::hasColumn('tickets', 'resolution_time')) {
            if (Schema::hasColumn('tickets', 'reconstructed_resolution_time')) {
                Schema::table('tickets', fn (Blueprint $table) => $table->renameColumn('reconstructed_resolution_time', 'resolution_time'));
            } else {
                Schema::table('tickets', fn (Blueprint $table) => $table->dateTime('resolution_time')->nullable());
            }
        }
    }

    public function down(): void
    {
        // Keep reconstructed datetimes for a later re-apply; do not discard deadline data.
        Schema::table('tickets', fn (Blueprint $table) => $table->renameColumn('resolution_time', 'reconstructed_resolution_time'));
        Schema::table('tickets', fn (Blueprint $table) => $table->renameColumn('legacy_resolution_time', 'resolution_time'));
    }
};
