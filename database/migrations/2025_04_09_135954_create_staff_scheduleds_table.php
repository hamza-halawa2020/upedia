<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_09_135954_create_staff_scheduleds_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_scheduleds', function (Blueprint $table) {
            $table->id();
            $table->string('course_name_en');
            $table->string('course_name_ar');
            $table->string('status');
            $table->string('session');
            $table->string('schedule');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('track_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('track_type_id');
            $table->unsignedBigInteger('track_level_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade');
            $table->foreign('track_type_id')->references('id')->on('track_types')->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');
            $table->foreign('track_level_id')->references('id')->on('track_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_scheduleds');
    }
};
