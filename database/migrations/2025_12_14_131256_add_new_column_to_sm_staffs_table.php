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
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->enum('payment_type', ['bank', 'wallet', 'cash'])->default('cash');
            $table->string('wallet_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn(['payment_type','wallet_number']);
        });
    }
};
