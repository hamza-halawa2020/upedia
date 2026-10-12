<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_scheduled_session', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->foreign('student_id')
            ->references('id')      
            ->on('sm_students')
            ->onDelete('cascade');
        $table->foreignId('scheduled_session_id')->constrained('scheduled_sessions')->onDelete('cascade');
        $table->boolean('is_presence')->default(false);
        $table->timestamps();
        $table->unique(['student_id', 'scheduled_session_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_scheduled_session');
    }
};
