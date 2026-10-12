<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('reviewed_by');
            $table->text('review_note')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->enum('review_status', ['pending', 'approved', 'rejected']);
            
            $table->enum('type', ['initial', 'mid', 'final']);

            $table->enum('level', ['Pioneer', 'Advanced', 'Super Advanced'])->nullable();
            $table->string('need')->nullable();
            $table->text('first_feedback')->nullable();
            $table->string('result')->nullable();
            $table->integer('score')->nullable();
            $table->enum('up_to_level', ['Pioneer', 'Advanced', 'Super Advanced'])->nullable();
            $table->integer('grammar')->nullable();
            $table->integer('speaking')->nullable();
            $table->integer('appropriacy')->nullable();
            $table->integer('listening')->nullable();
            $table->integer('reading')->nullable();
            $table->integer('writing')->nullable();
            $table->text('teachers_note')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_feedback');
    }
};
