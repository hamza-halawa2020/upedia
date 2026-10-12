<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduled_session_id')->constrained('scheduled_sessions')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->unsignedTinyInteger('admin_response_rating');
            $table->text('admin_response_comment')->nullable();
            $table->unsignedTinyInteger('quality_rating');
            $table->text('quality_comment')->nullable();
            $table->unsignedTinyInteger('benefit_rating');
            $table->text('benefit_comment')->nullable();
            $table->text('recommendation');
            $table->unsignedTinyInteger('error_correction_rating');
            $table->text('error_correction_comment')->nullable();
            $table->timestamps();
            $table->foreign('student_id')
                ->references('id')      
                ->on('sm_students')
                ->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
