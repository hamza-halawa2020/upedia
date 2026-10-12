<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //2025_04_09_135903_create_pricing_plan_types_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricing_plan_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plan_types');
    }
};
