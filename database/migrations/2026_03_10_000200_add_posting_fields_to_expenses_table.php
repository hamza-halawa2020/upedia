<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sm_add_expenses')) {
            return;
        }

        Schema::table('sm_add_expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_add_expenses', 'treasury_id')) {
                $table->foreignId('treasury_id')->nullable()->after('expense_head_id')->constrained('treasuries')->nullOnDelete();
            }

            if (!Schema::hasColumn('sm_add_expenses', 'cost_center_id')) {
                $table->foreignId('cost_center_id')->nullable()->after('treasury_id')->constrained('cost_centers')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sm_add_expenses')) {
            return;
        }

        Schema::table('sm_add_expenses', function (Blueprint $table) {
            if (Schema::hasColumn('sm_add_expenses', 'cost_center_id')) {
                $table->dropConstrainedForeignId('cost_center_id');
            }

            if (Schema::hasColumn('sm_add_expenses', 'treasury_id')) {
                $table->dropConstrainedForeignId('treasury_id');
            }
        });
    }
};
