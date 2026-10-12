<?php

use App\Models\CostCenter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('finanace_student_invoices') || Schema::hasColumn('finanace_student_invoices', 'cost_center_id')) {
            return;
        }

        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->foreignIdFor(CostCenter::class)->nullable()->after('sales_order_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('finanace_student_invoices') || !Schema::hasColumn('finanace_student_invoices', 'cost_center_id')) {
            return;
        }

        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cost_center_id');
        });
    }
};
