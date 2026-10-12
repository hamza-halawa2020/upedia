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
        Schema::create('crm_booking_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['demo', 'test'])->default('test');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->date('date');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_booking_requests');
    }
};
