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
        Schema::table('hr_settings', function (Blueprint $table) {
            $table->integer('allowed_period_to_pay_invoices')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_settings', function (Blueprint $table) {
            $table->dropColumn('allowed_period_to_pay_invoices');
        });
    }
};
