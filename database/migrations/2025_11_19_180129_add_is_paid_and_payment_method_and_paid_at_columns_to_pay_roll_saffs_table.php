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
        Schema::table('pay_roll_saffs', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pay_roll_saffs', function (Blueprint $table) {
            //
        });
    }
};
