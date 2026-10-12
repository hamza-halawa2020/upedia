<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE student_requests MODIFY COLUMN type ENUM('complaint', 'request', 'need', 'information', 'escalation', 'freeze', 'unfreeze', 'refund') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE student_requests MODIFY COLUMN type ENUM('complaint', 'request', 'need', 'information', 'escalation', 'freeze', 'unfreeze') NULL");
    }
};
