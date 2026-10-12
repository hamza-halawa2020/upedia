<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('exam_exam_attempts')) {
            Schema::table('exam_exam_attempts', function (Blueprint $table) {
                if (! Schema::hasColumn('exam_exam_attempts', 'student_exam_assignment_id')) {
                    $table->foreignId('student_exam_assignment_id')->nullable()->after('id')->constrained('student_exam_assignments')->nullOnDelete();
                }
                if (! Schema::hasColumn('exam_exam_attempts', 'course_student_id')) {
                    $table->foreignId('course_student_id')->nullable()->after('student_exam_assignment_id')->constrained('course_students')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('exam_exam_submissions')) {
            Schema::table('exam_exam_submissions', function (Blueprint $table) {
                if (! Schema::hasColumn('exam_exam_submissions', 'student_exam_assignment_id')) {
                    $table->foreignId('student_exam_assignment_id')->nullable()->after('id')->constrained('student_exam_assignments')->nullOnDelete();
                }
                if (! Schema::hasColumn('exam_exam_submissions', 'course_student_id')) {
                    $table->foreignId('course_student_id')->nullable()->after('student_exam_assignment_id')->constrained('course_students')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('exam_quiz_attempts')) {
            Schema::table('exam_quiz_attempts', function (Blueprint $table) {
                if (! Schema::hasColumn('exam_quiz_attempts', 'student_quiz_assignment_id')) {
                    $table->foreignId('student_quiz_assignment_id')->nullable()->after('id')->constrained('student_quiz_assignments')->nullOnDelete();
                }
                if (! Schema::hasColumn('exam_quiz_attempts', 'course_student_id')) {
                    $table->foreignId('course_student_id')->nullable()->after('student_quiz_assignment_id')->constrained('course_students')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('exam_quiz_submissions')) {
            Schema::table('exam_quiz_submissions', function (Blueprint $table) {
                if (! Schema::hasColumn('exam_quiz_submissions', 'student_quiz_assignment_id')) {
                    $table->foreignId('student_quiz_assignment_id')->nullable()->after('id')->constrained('student_quiz_assignments')->nullOnDelete();
                }
                if (! Schema::hasColumn('exam_quiz_submissions', 'course_student_id')) {
                    $table->foreignId('course_student_id')->nullable()->after('student_quiz_assignment_id')->constrained('course_students')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('exam_quiz_submissions') && Schema::hasColumn('exam_quiz_submissions', 'course_student_id')) {
            Schema::table('exam_quiz_submissions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_student_id');
                $table->dropConstrainedForeignId('student_quiz_assignment_id');
            });
        }

        if (Schema::hasTable('exam_quiz_attempts') && Schema::hasColumn('exam_quiz_attempts', 'course_student_id')) {
            Schema::table('exam_quiz_attempts', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_student_id');
                $table->dropConstrainedForeignId('student_quiz_assignment_id');
            });
        }

        if (Schema::hasTable('exam_exam_submissions') && Schema::hasColumn('exam_exam_submissions', 'course_student_id')) {
            Schema::table('exam_exam_submissions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_student_id');
                $table->dropConstrainedForeignId('student_exam_assignment_id');
            });
        }

        if (Schema::hasTable('exam_exam_attempts') && Schema::hasColumn('exam_exam_attempts', 'course_student_id')) {
            Schema::table('exam_exam_attempts', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_student_id');
                $table->dropConstrainedForeignId('student_exam_assignment_id');
            });
        }
    }
};
