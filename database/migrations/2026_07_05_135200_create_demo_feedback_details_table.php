<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demo_feedback_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_feedback_id')->constrained('teacher_feedback')->cascadeOnDelete();
            $table->foreignId('track_id')->constrained('tracks')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('track_levels')->nullOnDelete();
            $table->boolean('is_recommended')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['teacher_feedback_id', 'track_id'], 'demo_feedback_unique_feedback_track');
            $table->index(['track_id', 'level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_feedback_details');
    }
};
