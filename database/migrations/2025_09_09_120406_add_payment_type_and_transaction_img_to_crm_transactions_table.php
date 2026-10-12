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
            $table->enum('payment_type', ['instapay', 'online'])
                ->nullable()
                ->after('expire_at');
            $table->string('transaction_img')->nullable()->after('payment_type');
            $table->string('paypal_order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'transaction_img']);
        });
    }
};
