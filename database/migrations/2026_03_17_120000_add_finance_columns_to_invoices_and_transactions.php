<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('finanace_student_invoices', 'finance_journal_entry_id')) {
                $table->unsignedBigInteger('finance_journal_entry_id')->nullable()->after('staff_scheduleds_id');
            }
        });

        Schema::table('crm_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('crm_transactions', 'treasury_id')) {
                $table->unsignedBigInteger('treasury_id')->nullable()->after('payment_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('finanace_student_invoices', 'finance_journal_entry_id')) {
                $table->dropColumn('finance_journal_entry_id');
            }
        });

        Schema::table('crm_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('crm_transactions', 'treasury_id')) {
                $table->dropColumn('treasury_id');
            }
        });
    }
};
