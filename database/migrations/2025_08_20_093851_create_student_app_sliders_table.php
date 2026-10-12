<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_app_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('image');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_app_sliders');
    }
};
