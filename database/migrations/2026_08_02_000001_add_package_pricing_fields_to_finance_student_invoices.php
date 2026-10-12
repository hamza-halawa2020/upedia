<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('finanace_student_invoices', 'track_pricing_plan_id')) {
                $table->unsignedBigInteger('track_pricing_plan_id')->nullable();
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'package_id')) {
                $table->unsignedBigInteger('package_id')->nullable();
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'level_count')) {
                $table->unsignedBigInteger('level_count')->nullable();
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'level_price')) {
                $table->decimal('level_price', 12, 2)->nullable();
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'total_package_price')) {
                $table->decimal('total_package_price', 12, 2)->nullable();
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'reserved_level_ids')) {
                $table->json('reserved_level_ids')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            foreach ([
                'reserved_level_ids',
                'total_package_price',
                'level_price',
                'level_count',
                'package_id',
                'track_pricing_plan_id',
            ] as $column) {
                if (Schema::hasColumn('finanace_student_invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
