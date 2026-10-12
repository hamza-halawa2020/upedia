<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_09_135953_create_session_assignments_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('level_id');
            $table->string('title');
            $table->integer('marks');
            $table->float('min_percentage');
            $table->string('attachment')->nullable();
            $table->date('submit_date');
            $table->text('description')->nullable();
            $table->enum('privacy', ['locked', 'unlocked']);

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
        Schema::dropIfExists('session_assignments');
    }
};
