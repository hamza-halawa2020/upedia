<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_request_hard_copy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('staff_scheduled_id');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->foreign('staff_scheduled_id')->references('id')->on('staff_scheduleds')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_request_hard_copy');
    }
};
