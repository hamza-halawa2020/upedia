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
        Schema::create('demo_feedback_booking_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_feedback_id')->nullable()->constrained('teacher_feedback')->cascadeOnDelete();
            $table->foreignId('staff_scheduled_id')->nullable()->constrained('staff_scheduleds')->cascadeOnDelete();
            $table->foreignId('student_id')->nullable()->constrained('sm_students')->cascadeOnDelete();
            $table->foreignId('track_id')->constrained('tracks')->cascadeOnDelete();
            $table->foreignId('previous_track_level_id')->nullable()->constrained('track_levels')->cascadeOnDelete();
            $table->foreignId('new_track_level_id')->nullable()->constrained('track_levels')->cascadeOnDelete();
            $table->longText('previous_reserved_level_ids')->nullable();
            $table->longText('new_reserved_level_ids')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_deals');
    }
};
