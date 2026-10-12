<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            $table->string('payment_region')->default('both')->after('payment_flow');
            $table->boolean('is_payment_available')->default(false)->after('payment_region');
            $table->string('iban')->nullable()->after('is_payment_available');
        });
    }

    public function down(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            $table->dropColumn('is_payment_available');
            $table->dropColumn('payment_region');
            $table->dropColumn('iban');
        });
    }
};