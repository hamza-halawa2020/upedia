<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE crm_transactions MODIFY COLUMN status ENUM('pending', 'paid', 'rejected', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE crm_transactions SET status = 'rejected' WHERE status = 'cancelled'");
        DB::statement("ALTER TABLE crm_transactions MODIFY COLUMN status ENUM('pending', 'paid', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
