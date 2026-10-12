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
        Schema::create('exam_quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('total_marks')->nullable();
            $table->integer('total_duration')->nullable();
            $table->integer('total_questions')->nullable();
            $table->enum('type', ['quiz', 'assignment'])->default('quiz');
            $table->boolean('is_active')->default(false);
            $table->text('description')->nullable();
            $table->json('settings')->nullable();
            $table->foreignId('track_level_session_id')->nullable()->constrained('track_level_sessions')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_quizzes');
    }
};
