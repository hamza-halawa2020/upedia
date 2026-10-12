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
        Schema::table('crm_transactions', function (Blueprint $table) {
            // add expire_at and payment_url
            $table->text('payment_url')->nullable()->after('status');
            $table->dateTime('expire_at')->nullable()->index()->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_url', 'expire_at']);
        });
    }
};
