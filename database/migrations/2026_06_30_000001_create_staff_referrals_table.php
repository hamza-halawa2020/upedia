<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('name');
            $table->string('phone', 20);
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->string('cv')->nullable();
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('sm_staffs')->cascadeOnDelete();
            $table->foreign('job_title_id')->references('id')->on('hr_job_titles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_referrals');
    }
};
