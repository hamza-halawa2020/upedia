<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcement_staffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('staff_id');
            $table->timestamps();
            $table->foreign('announcement_id')->references('id')->on('announcements')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_staffs');
    }
};
