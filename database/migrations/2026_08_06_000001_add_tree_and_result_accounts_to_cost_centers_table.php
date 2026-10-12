<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cost_centers', function (Blueprint $table) {
            if (!Schema::hasColumn('cost_centers', 'parent_id')) {
                $table->foreignId('parent_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('cost_centers')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('cost_centers', 'revenue_account_id')) {
                $table->foreignId('revenue_account_id')
                    ->nullable()
                    ->after('status')
                    ->constrained('chart_of_accounts')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('cost_centers', 'expense_account_id')) {
                $table->foreignId('expense_account_id')
                    ->nullable()
                    ->after('revenue_account_id')
                    ->constrained('chart_of_accounts')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cost_centers', function (Blueprint $table) {
            if (Schema::hasColumn('cost_centers', 'expense_account_id')) {
                $table->dropConstrainedForeignId('expense_account_id');
            }

            if (Schema::hasColumn('cost_centers', 'revenue_account_id')) {
                $table->dropConstrainedForeignId('revenue_account_id');
            }

            if (Schema::hasColumn('cost_centers', 'parent_id')) {
                $table->dropConstrainedForeignId('parent_id');
            }
        });
    }
};
