<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_09_135952_create_track_level_sessions_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('track_level_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id');
            $table->unsignedBigInteger('level_id');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->json('file')->nullable(); // JSON for array cast
            $table->timestamps();

            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('track_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_level_sessions');
    }
};
