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
        Schema::create('hr_task_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('hr_tasks')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_task_students');
    }
};
