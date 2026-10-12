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
        Schema::create('hr_request_recruitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->nullable();
            $table->unsignedBigInteger('job_title_id');
            $table->text('role_description')->nullable();
            $table->text('required_qualifications_skills')->nullable();
            $table->unsignedBigInteger('number_of_vacancies')->default(1);
            $table->date('expected_start_date')->nullable();
            $table->text('justification_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_request_recruitments');
    }
};
