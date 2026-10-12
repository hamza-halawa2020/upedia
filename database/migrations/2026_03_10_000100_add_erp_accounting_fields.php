<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            if (!Schema::hasColumn('treasuries', 'account_id')) {
                $table->foreignId('account_id')->nullable()->after('name')->constrained('chart_of_accounts');
            }

            if (!Schema::hasColumn('treasuries', 'balance')) {
                $table->decimal('balance', 16, 2)->default(0)->after('opening_balance');
            }

            if (!Schema::hasColumn('treasuries', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
        });

        if (Schema::hasColumn('treasuries', 'opening_balance') && Schema::hasColumn('treasuries', 'balance')) {
            DB::table('treasuries')
                ->whereNull('balance')
                ->update(['balance' => DB::raw('opening_balance')]);
        }

        Schema::table('journal_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('journal_entries', 'type')) {
                $table->string('type', 30)->default('manual')->after('description');
            }

            if (!Schema::hasColumn('journal_entries', 'reference_no')) {
                $table->string('reference_no', 50)->nullable()->after('type');
                $table->index('reference_no');
            }

            if (!Schema::hasColumn('journal_entries', 'status')) {
                $table->string('status', 20)->default('draft')->after('reference_no');
                $table->index('status');
            }

            if (!Schema::hasColumn('journal_entries', 'posted_at')) {
                $table->timestamp('posted_at')->nullable()->after('status');
            }
        });

        Schema::table('treasury_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('treasury_transactions', 'journal_entry_id')) {
                $table->foreignId('journal_entry_id')->nullable()->after('treasury_id')->constrained('journal_entries')->nullOnDelete();
            }

            if (!Schema::hasColumn('treasury_transactions', 'direction')) {
                $table->string('direction', 10)->nullable()->after('amount');
                $table->index('direction');
            }

            if (!Schema::hasColumn('treasury_transactions', 'balance_after')) {
                $table->decimal('balance_after', 16, 2)->nullable()->after('direction');
            }
        });

        if (Schema::hasTable('sm_add_expenses')) {
            Schema::table('sm_add_expenses', function (Blueprint $table) {
                if (!Schema::hasColumn('sm_add_expenses', 'journal_entry_id')) {
                    $table->foreignId('journal_entry_id')->nullable()->after('expense_head_id')->constrained('journal_entries')->nullOnDelete();
                }

                if (!Schema::hasColumn('sm_add_expenses', 'posting_status')) {
                    $table->string('posting_status', 20)->default('posted')->after('journal_entry_id');
                    $table->index('posting_status');
                }

                if (!Schema::hasColumn('sm_add_expenses', 'transaction_type')) {
                    $table->string('transaction_type', 30)->default('expense')->after('posting_status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('sm_add_expenses')) {
            Schema::table('sm_add_expenses', function (Blueprint $table) {
                if (Schema::hasColumn('sm_add_expenses', 'transaction_type')) {
                    $table->dropColumn('transaction_type');
                }
                if (Schema::hasColumn('sm_add_expenses', 'posting_status')) {
                    $table->dropIndex(['posting_status']);
                    $table->dropColumn('posting_status');
                }
                if (Schema::hasColumn('sm_add_expenses', 'journal_entry_id')) {
                    $table->dropConstrainedForeignId('journal_entry_id');
                }
            });
        }

        Schema::table('treasury_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('treasury_transactions', 'balance_after')) {
                $table->dropColumn('balance_after');
            }
            if (Schema::hasColumn('treasury_transactions', 'direction')) {
                $table->dropIndex(['direction']);
                $table->dropColumn('direction');
            }
            if (Schema::hasColumn('treasury_transactions', 'journal_entry_id')) {
                $table->dropConstrainedForeignId('journal_entry_id');
            }
        });

        Schema::table('journal_entries', function (Blueprint $table) {
            if (Schema::hasColumn('journal_entries', 'posted_at')) {
                $table->dropColumn('posted_at');
            }
            if (Schema::hasColumn('journal_entries', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('journal_entries', 'reference_no')) {
                $table->dropIndex(['reference_no']);
                $table->dropColumn('reference_no');
            }
            if (Schema::hasColumn('journal_entries', 'type')) {
                $table->dropColumn('type');
            }
        });

        Schema::table('treasuries', function (Blueprint $table) {
            if (Schema::hasColumn('treasuries', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('treasuries', 'balance')) {
                $table->dropColumn('balance');
            }
            if (Schema::hasColumn('treasuries', 'account_id')) {
                $table->dropConstrainedForeignId('account_id');
            }
        });
    }
};
