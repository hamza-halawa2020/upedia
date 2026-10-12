<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_final_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreignId('staff_scheduled_id')->constrained('staff_scheduleds')->cascadeOnDelete();
            $table->foreignId('track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->foreignId('track_level_id')->nullable()->constrained('track_levels')->nullOnDelete();
            $table->enum('type', ['conversation_project', 'jolly_dictation']);
            $table->decimal('grade_percentage', 5, 2)->default(0);
            $table->decimal('weighted_score', 5, 2)->default(0);
            $table->text('feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('sm_students')->cascadeOnDelete();
            $table->unique(['student_id', 'staff_scheduled_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manual_final_grades');
    }
};
