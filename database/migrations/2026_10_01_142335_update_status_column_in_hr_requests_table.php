<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE hr_requests 
            MODIFY status ENUM('pending', 'in_progress', 'done', 'approved', 'rejected') 
            NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE hr_requests 
            MODIFY status ENUM('pending', 'in_progress', 'done', 'rejected') 
            NOT NULL DEFAULT 'pending'
        ");
    }
};