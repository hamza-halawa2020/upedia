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
        Schema::create('hr_recuirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('report_to')->nullable();

            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('job_type', ['full_time', 'part_time', 'contract', 'internship', 'freelance'])->default('full_time');
            // Other fields
            $table->string('salary_range')->nullable();
            $table->string('work_experience')->nullable();
            $table->date('due_date')->nullable();
            $table->string('prefered_age')->nullable();
            $table->text('job_description')->nullable();
            $table->text('required_skills')->nullable();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('sm_human_departments')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('hr_job_titles')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('report_to')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_recuirements');
    }
};
