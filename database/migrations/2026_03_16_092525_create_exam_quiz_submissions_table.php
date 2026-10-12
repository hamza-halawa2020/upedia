<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_quiz_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('exam_quizzes')->onDelete('cascade');
            $table->json('answers');
            $table->integer('total_time_seconds');
            $table->integer('time_taken_seconds')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->integer('total_marks')->default(0);
            $table->float('score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->boolean('passed')->default(0);
            $table->float('accuracy')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_quiz_submissions');
    }
};
