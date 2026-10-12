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
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
            $table->string('product_type')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('product_category_id')->nullable();
            $table->enum('discount_type',['percentage','fixed'])->default('percentage');
            $table->integer('discount');
            $table->integer('expire_day')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_settings');
    }
};
