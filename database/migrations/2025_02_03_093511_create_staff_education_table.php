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
        Schema::create('staff_education', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('staff_id');
            $table->string('university');
            $table->string('degree');
            $table->string('specialization');
            $table->string('date_of_completion');
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_education');
    }
};
