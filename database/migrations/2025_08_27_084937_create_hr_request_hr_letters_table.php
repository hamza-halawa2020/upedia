<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_request_hr_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->enum('reason_of_request', ['visa', 'bank', 'others']);
            $table->date('date_of_request');
            $table->string('letter_language')->default('en');
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_request_hr_letters');
    }
};
