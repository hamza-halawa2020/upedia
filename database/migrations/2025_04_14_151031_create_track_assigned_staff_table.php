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
        //2025_04_14_151031_create_track_assigned_staff_table.php
        Schema::create('track_assigned_staff', function (Blueprint $table) {
            $table->id();

            $table->integer('category_id');
            $table->string('track_type_id');
            $table->string('levels')->nullable();

            $table->foreignId('staff_id')->constrained('sm_staffs')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_assigned_staff');
    }
};
