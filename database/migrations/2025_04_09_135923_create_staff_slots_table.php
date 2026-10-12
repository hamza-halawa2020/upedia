<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //2025_04_09_135923_create_staff_slots_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('slot_id');
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('slot_emps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_slots');
    }
};
