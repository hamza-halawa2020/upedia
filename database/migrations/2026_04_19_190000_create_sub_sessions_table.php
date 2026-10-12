<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheduled_session_id');
            $table->unsignedBigInteger('staff_scheduled_id');
            $table->unsignedBigInteger('track_id')->nullable();
            $table->unsignedBigInteger('track_level_id')->nullable();
            $table->unsignedBigInteger('track_session_id')->nullable();
            $table->string('type');
            $table->string('status')->default('pending');
            $table->json('student_ids')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('scheduled_session_id')->references('id')->on('scheduled_sessions')->onDelete('cascade');
            $table->foreign('staff_scheduled_id')->references('id')->on('staff_scheduleds')->onDelete('cascade');
            $table->foreign('track_session_id')->references('id')->on('track_level_sessions')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['scheduled_session_id', 'staff_scheduled_id']);
            $table->index('type');
            $table->unique('scheduled_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_sessions');
    }
};
