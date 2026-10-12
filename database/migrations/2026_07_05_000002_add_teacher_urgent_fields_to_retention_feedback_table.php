<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('retention_feedback', function (Blueprint $table) {
            $table->boolean('mic_issues')->default(false)->after('internet_not_stable');
            $table->boolean('teacher_language')->default(false)->after('mic_issues');
            $table->boolean('materials_issues')->default(false)->after('teacher_language');
            $table->boolean('teacher_attitude')->default(false)->after('materials_issues');
            $table->boolean('teacher_commitment')->default(false)->after('teacher_attitude');
        });
    }

    public function down(): void
    {
        Schema::table('retention_feedback', function (Blueprint $table) {
            $table->dropColumn([
                'mic_issues',
                'teacher_language',
                'materials_issues',
                'teacher_attitude',
                'teacher_commitment',
            ]);
        });
    }
};
