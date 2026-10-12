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
        Schema::create('academy_scheduled_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_day');
            $table->time('slot_start');
            $table->time('slot_end');
            $table->unsignedBigInteger('staff_scheduled_id');
            $table->unsignedBigInteger('slot_emp_id');

            // $table->foreign('staff_scheduled_id')->references('id')->on('staff_scheduleds')->onDelete('cascade');
            // $table->foreign('slot_emp_id')->references('id')->on('slot_emps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_scheduled_slots');
    }
};
