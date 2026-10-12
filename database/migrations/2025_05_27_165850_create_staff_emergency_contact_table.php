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
        Schema::create('staff_emergency_contact', function (Blueprint $table) {
            $table->id();
            $table->string('emergency_name');
            $table->enum('emergency_relationship', ['Father', 'Mother', 'Brother', 'Wife']);
            $table->string('emergency_mobile');
            $table->string('emergency_home_telephone');
            $table->string('emergency_work_telephone');
            $table->unsignedBigInteger('staff_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_emergency_contact');
    }
};
