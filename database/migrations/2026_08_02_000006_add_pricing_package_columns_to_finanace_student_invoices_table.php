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
                $table->unsignedBigInteger('track_pricing_plan_id')
                    ->nullable()
                    ->after('package_id');

                $table->index('track_pricing_plan_id', 'fsi_track_pricing_plan_id_index');
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'total_package_price')) {
                $table->decimal('total_package_price', 10, 2)
                    ->default(0)
                    ->after('track_pricing_plan_id');
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'level_count')) {
                $table->unsignedTinyInteger('level_count')
                    ->default(1)
                    ->after('total_package_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('finanace_student_invoices', 'track_pricing_plan_id')) {
                $table->dropIndex('fsi_track_pricing_plan_id_index');
                $table->dropColumn('track_pricing_plan_id');
            }

            if (Schema::hasColumn('finanace_student_invoices', 'total_package_price')) {
                $table->dropColumn('total_package_price');
            }

            if (Schema::hasColumn('finanace_student_invoices', 'level_count')) {
                $table->dropColumn('level_count');
            }
        });
    }
};
