<?php

use App\Models\CostCenter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('purchases')) {
            return;
        }

        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'invoice_type')) {
                $table->string('invoice_type', 30)->default('purchase')->after('purchase_number');
            }

            if (!Schema::hasColumn('purchases', 'party_type')) {
                $table->string('party_type', 100)->nullable()->after('invoice_type');
            }

            if (!Schema::hasColumn('purchases', 'due_date')) {
                $table->date('due_date')->nullable()->after('required_by');
            }

            if (!Schema::hasColumn('purchases', 'expense_head_id')) {
                $table->unsignedBigInteger('expense_head_id')->nullable()->after('due_date');
            }

            if (!Schema::hasColumn('purchases', 'cost_center_id')) {
                $table->foreignIdFor(CostCenter::class)->nullable()->after('expense_head_id')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('purchases', 'apply_vat')) {
                $table->boolean('apply_vat')->default(false)->after('shipping_cost');
            }

            if (!Schema::hasColumn('purchases', 'vat_amount')) {
                $table->decimal('vat_amount', 16, 2)->default(0)->after('apply_vat');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('purchases')) {
            return;
        }

        Schema::table('purchases', function (Blueprint $table) {
            foreach (['vat_amount', 'apply_vat', 'due_date', 'party_type', 'invoice_type'] as $column) {
                if (Schema::hasColumn('purchases', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('purchases', 'cost_center_id')) {
                $table->dropConstrainedForeignId('cost_center_id');
            }

            if (Schema::hasColumn('purchases', 'expense_head_id')) {
                $table->dropColumn('expense_head_id');
            }
        });
    }
};
