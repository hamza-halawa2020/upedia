<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            if (! Schema::hasColumn('staff_target_configurations', 'target_type')) {
                $table->enum('target_type', ['number', 'percentage'])->after('job_title_id')->default('number');
            }

            if (Schema::hasColumn('staff_target_configurations', 'quarter')) {
                $table->dropColumn('quarter');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            if (! Schema::hasColumn('staff_target_configurations', 'quarter')) {
                $table->enum('quarter', ['Q1', 'Q2', 'Q3', 'Q4'])->after('percentage')->nullable();
            }

            if (Schema::hasColumn('staff_target_configurations', 'target_type')) {
                $table->dropColumn('target_type');
            }
        });
    }
};
