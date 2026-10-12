<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->enum('schedule_type', ['course', 'track'])->after('track_id')->default('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->dropColumn('schedule_type');
        });
    }
};
