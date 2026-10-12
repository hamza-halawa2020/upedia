<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE crm_calls MODIFY action ENUM('interested', 'not_interested', 'reschedule', 'not_answered', 'wrong_number', 'pending') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE crm_calls MODIFY action ENUM('interested', 'not_interested', 'reschedule', 'not_answered', 'pending') DEFAULT 'pending'");
    }
};
