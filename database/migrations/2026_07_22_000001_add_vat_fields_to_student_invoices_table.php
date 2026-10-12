<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('finanace_student_invoices', 'apply_vat')) {
                $table->boolean('apply_vat')->default(false)->after('total_price');
            }

            if (!Schema::hasColumn('finanace_student_invoices', 'vat_rate')) {
                $table->decimal('vat_rate', 5, 2)->default(0)->after('apply_vat');
            }

            if (!Schema::hasColumn('finanace_student_invoices', 'vat_amount')) {
                $table->decimal('vat_amount', 15, 2)->default(0)->after('vat_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            foreach (['vat_amount', 'vat_rate', 'apply_vat'] as $column) {
                if (Schema::hasColumn('finanace_student_invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
