<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_09_135953_create_session_lessons_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('level_id');
            $table->string('name');
            $table->integer('duration');
            $table->enum('privacy', ['locked', 'unlocked']);
            $table->enum('host_type', ['image', 'youtube', 'video', 'pdf', 'word', 'excel']);
            $table->string('host_path');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('track_level_sessions')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('track_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_lessons');
    }
};
