<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestExperienceLettersTable extends Migration
{
    public function up(): void
    {
        Schema::create('request_experience_letters', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('staff_id');
            $table->string('reason_of_request')->nullable();
            $table->string('request_type')->nullable();
            $table->date('date_of_request')->nullable();
            $table->enum('letter_language', ['en', 'ar']);
            $table->text('additional_information')->nullable();
            $table->string('attachment')->nullable();

            $table->timestamps();

            // optional foreign key
            // $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_experience_letters');
    }
}
