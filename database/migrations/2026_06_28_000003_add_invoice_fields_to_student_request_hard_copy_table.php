<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            if (! Schema::hasColumn('student_request_hard_copy', 'certificate_payment_configuration_id')) {
                $table->unsignedBigInteger('certificate_payment_configuration_id')->nullable();
            }

            if (! Schema::hasColumn('student_request_hard_copy', 'finanace_student_invoice_id')) {
                $table->unsignedBigInteger('finanace_student_invoice_id')->nullable();
            }

            if (! Schema::hasColumn('student_request_hard_copy', 'certificate_price')) {
                $table->decimal('certificate_price', 10, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $columns = [
                'certificate_payment_configuration_id',
                'finanace_student_invoice_id',
                'certificate_price',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('student_request_hard_copy', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
