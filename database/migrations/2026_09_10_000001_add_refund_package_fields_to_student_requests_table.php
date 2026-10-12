<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('student_requests', 'refund_package_name')) {
                $table->string('refund_package_name')->nullable()->after('refund_invoice_amount');
            }

            if (! Schema::hasColumn('student_requests', 'package_level_deduction_amount')) {
                $table->decimal('package_level_deduction_amount', 12, 2)->nullable()->after('refund_package_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            foreach ([
                'package_level_deduction_amount',
                'refund_package_name',
            ] as $column) {
                if (Schema::hasColumn('student_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
