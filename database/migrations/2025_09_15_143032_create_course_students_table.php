<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_15_143032_create_course_students_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('staff_scheduleds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_students');
    }
};
