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
        Schema::create('scheduled_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_scheduled_id');
            $table->integer('session_number');
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('track_session_id')->nullable();
            $table->unsignedBigInteger('staff_slot_id');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_sessions');
    }
};
