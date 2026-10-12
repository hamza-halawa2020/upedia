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
        Schema::create('performace_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->longText('goals')->nullable();
            $table->longText('feedback')->nullable();
            $table->longText('listening')->nullable();
            $table->longText('reading')->nullable();
            $table->longText('speaking')->nullable();
            $table->longText('vocabulary')->nullable();
            $table->longText('grammar')->nullable();
            $table->json('objectives')->nullable();
            $table->timestamps();

            $table->unique(['schedule_id', 'student_id','teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performace_reports');
    }
};
