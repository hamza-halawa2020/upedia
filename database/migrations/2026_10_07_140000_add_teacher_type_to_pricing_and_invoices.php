<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->string('teacher_type')->default('native_like')->after('package_id');
        });

        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->string('teacher_type')->nullable()->after('track_pricing_plan_id');
        });

        DB::table('track_pricing_plans')->whereNull('teacher_type')->orWhere('teacher_type', '')->update(['teacher_type' => 'native_like']);
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropColumn('teacher_type');
        });

        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropColumn('teacher_type');
        });
    }
};
