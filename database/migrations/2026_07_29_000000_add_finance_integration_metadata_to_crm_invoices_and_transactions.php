<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('finanace_student_invoices', 'staff_scheduleds_id')) {
                $table->unsignedBigInteger('staff_scheduleds_id')->nullable()->index();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'source_service')) {
                $table->string('source_service', 100)->nullable()->index();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_booking_reference')) {
                $table->string('external_booking_reference')->nullable()->index();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_schedule_reference')) {
                $table->string('external_schedule_reference')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_student_reference')) {
                $table->string('external_student_reference')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_course_reference')) {
                $table->string('external_course_reference')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_course_name')) {
                $table->string('external_course_name')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'external_student_name')) {
                $table->string('external_student_name')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'currency')) {
                $table->char('currency', 3)->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'sessions_count')) {
                $table->unsignedBigInteger('sessions_count')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'registration_type')) {
                $table->string('registration_type')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'sales_order_id')) {
                $table->unsignedBigInteger('sales_order_id')->nullable()->index();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'sales_order_reference')) {
                $table->string('sales_order_reference')->nullable();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'invoice_journal_entry_id')) {
                $table->unsignedBigInteger('invoice_journal_entry_id')->nullable()->index();
            }
            if (! Schema::hasColumn('finanace_student_invoices', 'finance_status')) {
                $table->string('finance_status')->nullable();
            }
        });

        Schema::table('crm_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('crm_transactions', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->index();
            }
            if (! Schema::hasColumn('crm_transactions', 'external_transaction_reference')) {
                $table->string('external_transaction_reference')->nullable()->index();
            }
            if (! Schema::hasColumn('crm_transactions', 'finance_payment_id')) {
                $table->unsignedBigInteger('finance_payment_id')->nullable()->index();
            }
            if (! Schema::hasColumn('crm_transactions', 'finance_synced_at')) {
                $table->timestamp('finance_synced_at')->nullable();
            }
            if (! Schema::hasColumn('crm_transactions', 'finance_sync_error')) {
                $table->text('finance_sync_error')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('crm_transactions', function (Blueprint $table) {
            $columns = [
                'payment_reference',
                'external_transaction_reference',
                'finance_payment_id',
                'finance_synced_at',
                'finance_sync_error',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('crm_transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $columns = [
                'staff_scheduleds_id',
                'source_service',
                'external_booking_reference',
                'external_schedule_reference',
                'external_student_reference',
                'external_course_reference',
                'external_course_name',
                'external_student_name',
                'currency',
                'sessions_count',
                'registration_type',
                'sales_order_id',
                'sales_order_reference',
                'invoice_journal_entry_id',
                'finance_status',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('finanace_student_invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
