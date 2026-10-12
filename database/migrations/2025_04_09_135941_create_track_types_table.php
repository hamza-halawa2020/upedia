<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //2025_04_09_135941_create_track_types_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('track_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('count_of_students')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_types');
    }
};
