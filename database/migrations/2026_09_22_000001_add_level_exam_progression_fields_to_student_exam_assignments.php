<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('student_exam_assignments')) {
            return;
        }

        Schema::table('student_exam_assignments', function (Blueprint $table) {
            if (! Schema::hasColumn('student_exam_assignments', 'track_level_id')) {
                $table->foreignId('track_level_id')
                    ->nullable()
                    ->after('course_student_id')
                    ->constrained('track_levels')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('student_exam_assignments', 'result')) {
                $table->string('result')->nullable()->after('status');
            }

            if (! Schema::hasColumn('student_exam_assignments', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('result');
            }

            if (! Schema::hasColumn('student_exam_assignments', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('submitted_at');
            }

            if (! Schema::hasColumn('student_exam_assignments', 'repeat_course_student_id')) {
                $table->foreignId('repeat_course_student_id')
                    ->nullable()
                    ->after('processed_at')
                    ->constrained('course_students')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('student_exam_assignments')) {
            return;
        }

        Schema::table('student_exam_assignments', function (Blueprint $table) {
            foreach (['repeat_course_student_id', 'track_level_id'] as $column) {
                if (Schema::hasColumn('student_exam_assignments', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach (['processed_at', 'submitted_at', 'result'] as $column) {
                if (Schema::hasColumn('student_exam_assignments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
