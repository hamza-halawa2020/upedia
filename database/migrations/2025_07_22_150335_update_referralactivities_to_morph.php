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
        Schema::table('referralactivities', function (Blueprint $table) {
            // احذف الأعمدة القديمة لو موجودة
            $table->dropColumn(['user_id', 'referred_id']);

            // أضف أعمدة morph
            $table->unsignedBigInteger('userable_id')->nullable();
            $table->string('userable_type')->nullable();

            $table->unsignedBigInteger('referredable_id')->nullable();
            $table->string('referredable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referralactivities', function (Blueprint $table) {
            $table->dropColumn(['userable_id', 'userable_type', 'referredable_id', 'referredable_type']);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('referred_id')->nullable();
        });
    }
};
