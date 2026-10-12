<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('crm_transactions', 'gateway')) {
                $table->string('gateway')->nullable()->after('payment_type');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_order_id')) {
                $table->string('gateway_order_id')->nullable()->after('gateway');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_payment_id')) {
                $table->string('gateway_payment_id')->nullable()->after('gateway_order_id');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_payment_request_id')) {
                $table->string('gateway_payment_request_id')->nullable()->after('gateway_payment_id');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_reference')) {
                $table->string('gateway_reference')->nullable()->after('gateway_payment_request_id');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_status')) {
                $table->string('gateway_status')->nullable()->after('gateway_reference');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_signature')) {
                $table->string('gateway_signature')->nullable()->after('gateway_status');
            }

            if (! Schema::hasColumn('crm_transactions', 'gateway_payload')) {
                $table->json('gateway_payload')->nullable()->after('gateway_signature');
            }
        });
    }

    public function down(): void
    {
        Schema::table('crm_transactions', function (Blueprint $table) {
            foreach ([
                'gateway_payload',
                'gateway_signature',
                'gateway_status',
                'gateway_reference',
                'gateway_payment_request_id',
                'gateway_payment_id',
                'gateway_order_id',
                'gateway',
            ] as $column) {
                if (Schema::hasColumn('crm_transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
