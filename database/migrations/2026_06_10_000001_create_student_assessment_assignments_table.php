<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('student_exam_assignments')) {
            Schema::create('student_exam_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_student_id')->constrained('course_students')->cascadeOnDelete();
                $table->unsignedBigInteger('exam_id');
                $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('available_from')->nullable();
                $table->timestamp('available_until')->nullable();
                $table->string('status', 32)->default('assigned');
                $table->timestamps();

                $table->unique(['course_student_id', 'exam_id'], 'student_exam_assignments_unique');
                $table->index(['course_student_id', 'status'], 'student_exam_assignments_status_index');
                $table->index('exam_id');
            });
        }

        if (! Schema::hasTable('student_quiz_assignments')) {
            Schema::create('student_quiz_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_student_id')->constrained('course_students')->cascadeOnDelete();
                $table->unsignedBigInteger('quiz_id');
                $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('available_from')->nullable();
                $table->timestamp('available_until')->nullable();
                $table->string('status', 32)->default('assigned');
                $table->timestamps();

                $table->unique(['course_student_id', 'quiz_id'], 'student_quiz_assignments_unique');
                $table->index(['course_student_id', 'status'], 'student_quiz_assignments_status_index');
                $table->index('quiz_id');
            });
        }

        if (! Schema::hasTable('student_assignment_assignments')) {
            Schema::create('student_assignment_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_student_id')->constrained('course_students')->cascadeOnDelete();
                $table->unsignedBigInteger('assignment_id');
                $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('available_from')->nullable();
                $table->timestamp('available_until')->nullable();
                $table->string('status', 32)->default('assigned');
                $table->timestamps();

                $table->unique(['course_student_id', 'assignment_id'], 'student_assignment_assignments_unique');
                $table->index(['course_student_id', 'status'], 'student_assignment_assignments_status_index');
                $table->index('assignment_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('student_assignment_assignments');
        Schema::dropIfExists('student_quiz_assignments');
        Schema::dropIfExists('student_exam_assignments');
    }
};
