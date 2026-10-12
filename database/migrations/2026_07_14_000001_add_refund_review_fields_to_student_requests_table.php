<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('student_requests', 'refund_invoice_amount')) {
                $table->decimal('refund_invoice_amount', 12, 2)->nullable()->after('status_note');
            }

            if (! Schema::hasColumn('student_requests', 'deduct_administrative_expenses')) {
                $table->boolean('deduct_administrative_expenses')->default(false)->after('refund_invoice_amount');
            }

            if (! Schema::hasColumn('student_requests', 'additional_refund_amount')) {
                $table->decimal('additional_refund_amount', 12, 2)->default(0)->after('deduct_administrative_expenses');
            }

            if (! Schema::hasColumn('student_requests', 'refund_amount')) {
                $table->decimal('refund_amount', 12, 2)->nullable()->after('additional_refund_amount');
            }
        });

        if (Schema::hasColumn('student_requests', 'status') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','submitted','approved','assigned','in_progress','resolved','finance_review','rejected','closed') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            foreach ([
                'refund_amount',
                'additional_refund_amount',
                'deduct_administrative_expenses',
                'refund_invoice_amount',
            ] as $column) {
                if (Schema::hasColumn('student_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        if (Schema::hasColumn('student_requests', 'status') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','approved','assigned','in_progress','resolved','rejected','closed') NOT NULL DEFAULT 'pending'");
        }
    }
};
