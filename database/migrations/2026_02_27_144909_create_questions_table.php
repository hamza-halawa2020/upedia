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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_type_id')->constrained('exam_question_types')->onDelete('cascade');
            $table->string('question');
            $table->integer('default_marks');
            $table->integer('default_time');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('track_levels')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('track_level_sessions')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->softDeletes();


            $table->timestamps();
        });
    }
  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
