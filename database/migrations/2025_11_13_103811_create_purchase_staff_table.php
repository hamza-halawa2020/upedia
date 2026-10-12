<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_staff');
    }
};
