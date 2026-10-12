<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversation_project_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreignId('staff_scheduled_id')->constrained('staff_scheduleds')->cascadeOnDelete();
            $table->foreignId('exam_attempt_id')->nullable()->constrained('exam_exam_attempts')->nullOnDelete();
            $table->string('uploaded_file_path');
            $table->decimal('vocabulary_score', 5, 2)->nullable();
            $table->decimal('grammar_score', 5, 2)->nullable();
            $table->decimal('speaking_score', 5, 2)->nullable();
            $table->decimal('understanding_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->default(0);
            $table->decimal('weighted_score', 5, 2)->default(0);
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->enum('status', ['pending_review', 'reviewed'])->default('pending_review');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('sm_students')->cascadeOnDelete();
            $table->unique(['student_id', 'staff_scheduled_id'], 'cps_student_course_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_project_submissions');
    }
};
