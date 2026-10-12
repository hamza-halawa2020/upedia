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
        Schema::create('academy_product_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(); 
            $table->unsignedBigInteger('staff_id')->nullable();

            // Define foreign keys
            $table->foreign('product_id')->references('id')->on('academy_products')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_product_staff');
    }
};
