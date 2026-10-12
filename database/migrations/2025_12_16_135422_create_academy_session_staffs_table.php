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
        Schema::create('academy_session_staffs', function (Blueprint $table) {
            $table->id();
            $table->date('session_date');
            $table->unsignedBigInteger('track_level_session_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('slot_id');
            $table->foreign('track_level_session_id')->references('id')->on('track_level_sessions')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('slot_emps')->onDelete('cascade');

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_session_staffs');
    }
};
