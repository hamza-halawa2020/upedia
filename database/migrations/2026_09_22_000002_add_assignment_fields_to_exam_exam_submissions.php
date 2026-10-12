<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('exam_exam_submissions')) {
            return;
        }

        Schema::table('exam_exam_submissions', function (Blueprint $table) {
            if (! Schema::hasColumn('exam_exam_submissions', 'student_exam_assignment_id')) {
                $table->foreignId('student_exam_assignment_id')
                    ->nullable()
                    ->after('exam_id')
                    ->constrained('student_exam_assignments')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('exam_exam_submissions', 'course_student_id')) {
                $table->foreignId('course_student_id')
                    ->nullable()
                    ->after('student_exam_assignment_id')
                    ->constrained('course_students')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('exam_exam_submissions')) {
            return;
        }

        Schema::table('exam_exam_submissions', function (Blueprint $table) {
            foreach (['course_student_id', 'student_exam_assignment_id'] as $column) {
                if (Schema::hasColumn('exam_exam_submissions', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }
        });
    }
};
