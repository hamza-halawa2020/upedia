<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE applicants MODIFY COLUMN stage_status ENUM('induction', 'training', 'rejected', 'rescheduling', 'pending', 'scheduled', 'no-show') DEFAULT 'pending'");
        DB::statement("ALTER TABLE applicants MODIFY COLUMN stage_result ENUM('passed', 'failed', 'no-show') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE applicants MODIFY COLUMN stage_status ENUM('induction', 'training', 'rejected', 'rescheduling', 'pending', 'scheduled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE applicants MODIFY COLUMN stage_result ENUM('passed', 'failed', 'no-show') DEFAULT NULL");
    }
};
