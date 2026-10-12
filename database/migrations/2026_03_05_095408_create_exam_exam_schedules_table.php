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
        Schema::create('exam_exam_schedules', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exam_id')->constrained('exam_exams')->onDelete('cascade');
            $table->foreignId('staff_scheduled_id')->constrained('staff_scheduleds')->onDelete('cascade');
            $table->enum('schedule_type', ['fixed', 'flexible']); 
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('grace_period')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_exam_schedules');
    }
};
