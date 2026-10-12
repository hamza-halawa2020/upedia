<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //2025_04_09_135952_create_track_pricing_plans_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('track_pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id');
            $table->unsignedBigInteger('pricing_plan_type_id');
            $table->unsignedBigInteger('track_type_id');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');
            $table->foreign('pricing_plan_type_id')->references('id')->on('pricing_plan_types')->onDelete('cascade');
            $table->foreign('track_type_id')->references('id')->on('track_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_pricing_plans');
    }
};
