<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_exams', function (Blueprint $table) {
            // $table->integer('pre_days_duration')->default(0)->after('total_duration');
        });
    }

    public function down(): void
    {
        Schema::table('exam_exams', function (Blueprint $table) {
            // $table->dropColumn('pre_days_duration');
        });
    }
};
