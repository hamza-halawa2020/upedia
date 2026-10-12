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
        Schema::create('referralactivities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('referred_id');
            $table->string('product_type')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('product_category_id')->nullable();
            $table->enum('discount_type',['percentage','fixed'])->nullable();
            $table->integer('discount')->nullable();
            $table->integer('expire_day')->nullable();
            $table->enum('status',['not_active','active'])->default('active');
            $table->enum('is_used',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referralactivities');
    }
};
