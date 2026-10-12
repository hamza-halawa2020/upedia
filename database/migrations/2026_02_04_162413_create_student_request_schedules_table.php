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
        Schema::create('student_request_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_request_id')->constrained('student_requests')->onDelete('cascade');
            $table->string('day');
            $table->time('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_request_schedules');
    }
};
