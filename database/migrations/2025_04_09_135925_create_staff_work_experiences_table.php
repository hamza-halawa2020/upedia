<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //2025_04_09_135925_create_staff_work_experiences_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->string('company_name');
            $table->string('title');
            $table->date('from');
            $table->date('to')->nullable();
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_work_experiences');
    }
};
