<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('staff_id');
            $table->text('reply_text')->nullable();
            $table->timestamps();
            $table->foreign('request_id')->references('id')->on('hr_requests')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
