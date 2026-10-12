<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE crm_leads MODIFY status ENUM('pending', 'not_contacted', 'answer', 'no_answer', 'wrong_number', 'switched_off', 'invalid_number', 'interested', 'not_interested', 'reschedule', 'follow_up_payment', 'test', 'demo', 'paid', 'negotiation', 'close_lost') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE crm_leads MODIFY status ENUM('pending', 'interested', 'not_interested') DEFAULT 'pending'");
    }
};
