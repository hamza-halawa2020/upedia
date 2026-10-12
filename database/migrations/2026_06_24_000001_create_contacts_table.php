<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->text('message');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('sm_students')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
