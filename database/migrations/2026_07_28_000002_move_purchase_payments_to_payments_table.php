<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'purchase_invoice_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->foreignId('purchase_invoice_id')
                    ->nullable()
                    ->after('source_type')
                    ->constrained('purchase_invoices')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'treasury_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->foreignId('treasury_id')
                    ->nullable()
                    ->after('purchase_invoice_id')
                    ->constrained('treasuries')
                    ->nullOnDelete();
            });
        }

        Schema::dropIfExists('purchase_payments');
    }

    public function down(): void
    {
        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'purchase_invoice_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropConstrainedForeignId('purchase_invoice_id');
            });
        }

        if (Schema::hasTable('payments') && Schema::hasColumn('payments', 'treasury_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropConstrainedForeignId('treasury_id');
            });
        }
    }
};
