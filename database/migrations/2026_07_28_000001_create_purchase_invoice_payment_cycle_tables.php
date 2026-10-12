<?php

use App\Models\CostCenter;
use App\Models\JournalEntry;
use App\Models\Purchase;
use App\Models\Treasury;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->string('vendor_invoice_number')->nullable();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('sub_total', 16, 2)->default(0);
            $table->decimal('vat_amount', 16, 2)->default(0);
            $table->decimal('shipping_cost', 16, 2)->default(0);
            $table->decimal('total', 16, 2)->default(0);
            $table->decimal('paid_amount', 16, 2)->default(0);
            $table->decimal('remaining_amount', 16, 2)->default(0);
            $table->string('status', 30)->default('unpaid')->index();
            $table->foreignIdFor(CostCenter::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(JournalEntry::class, 'invoice_journal_entry_id')->nullable()->constrained('journal_entries')->nullOnDelete();
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('it_vendors')->nullOnDelete();
            $table->index(['purchase_id', 'status']);
        });

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
                $table->foreignIdFor(Treasury::class)
                    ->nullable()
                    ->after('purchase_invoice_id')
                    ->constrained()
                    ->nullOnDelete();
            });
        }

        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases', 'purchase_invoice_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->unsignedBigInteger('purchase_invoice_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases', 'purchase_invoice_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('purchase_invoice_id');
            });
        }

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

        Schema::dropIfExists('purchase_invoices');
    }
};
