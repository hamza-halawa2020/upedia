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
        Schema::create('induction_training_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('staff_session_slot_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('session_number')->nullable();
            $table->enum('status', ['induction', 'training', 'rejected', 'rescheduling','pending'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('induction_training_staff');
    }
};
