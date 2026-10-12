<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('exam_exams') && ! Schema::hasColumn('exam_exams', 'pre_days_duration')) {
            Schema::table('exam_exams', function (Blueprint $table) {
                $table->unsignedBigInteger('pre_days_duration')->default(0)->after('total_duration');
            });
        }

        if (! Schema::hasTable('student_exam_assignments')) {
            Schema::create('student_exam_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_student_id')->constrained('course_students')->cascadeOnDelete();
                $table->foreignId('exam_id')->constrained('exam_exams')->cascadeOnDelete();
                $table->unsignedBigInteger('track_level_id')->nullable();
                $table->unsignedBigInteger('repeat_course_student_id')->nullable();
                $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('available_from')->nullable();
                $table->timestamp('available_until')->nullable();
                $table->string('result')->nullable();
                $table->string('status', 40)->default('available');
                $table->timestamps();

                $table->unique(['course_student_id', 'exam_id'], 'student_exam_assignments_course_exam_unique');
                $table->index(['course_student_id', 'status'], 'student_exam_assignments_course_status_index');
                $table->index(['exam_id', 'status'], 'student_exam_assignments_exam_status_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('student_exam_assignments');

        if (Schema::hasTable('exam_exams') && Schema::hasColumn('exam_exams', 'pre_days_duration')) {
            Schema::table('exam_exams', function (Blueprint $table) {
                $table->dropColumn('pre_days_duration');
            });
        }
    }
};
