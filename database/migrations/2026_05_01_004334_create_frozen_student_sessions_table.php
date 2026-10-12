<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('frozen_student_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->foreignId('staff_scheduled_id')->constrained('staff_scheduleds')->onDelete('cascade');
            $table->integer('session_number')->nullable();
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('staff_slot_id')->nullable();
            $table->unsignedBigInteger('track_session_id')->nullable();
            $table->foreignId('request_id')->constrained('student_requests')->onDelete('cascade');
            $table->boolean('is_paid')->default(false);
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });


    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frozen_student_sessions');
    }
};
