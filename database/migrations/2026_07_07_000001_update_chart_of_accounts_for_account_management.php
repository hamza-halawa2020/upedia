<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('chart_of_accounts', 'name_en')) {
                $table->string('name_en')->nullable()->after('title');
            }

            if (!Schema::hasColumn('chart_of_accounts', 'account_type')) {
                $table->string('account_type', 30)->nullable()->after('parent_id')->index();
            }

            if (!Schema::hasColumn('chart_of_accounts', 'account_nature')) {
                $table->string('account_nature', 10)->nullable()->after('account_type')->index();
            }

            if (!Schema::hasColumn('chart_of_accounts', 'is_nature_inherited')) {
                $table->boolean('is_nature_inherited')->default(false)->after('account_nature')->index();
            }
        });

        DB::table('chart_of_accounts')
            ->whereNull('is_nature_inherited')
            ->update(['is_nature_inherited' => false]);

        DB::table('chart_of_accounts')->where('code', '1')->update([
            'account_type' => 'asset',
            'account_nature' => 'debit',
            'is_nature_inherited' => false,
        ]);
        DB::table('chart_of_accounts')->where('code', '2')->update([
            'account_type' => 'liability',
            'account_nature' => 'credit',
            'is_nature_inherited' => false,
        ]);
        DB::table('chart_of_accounts')->where('code', '3')->update([
            'account_type' => 'expense',
            'account_nature' => 'debit',
            'is_nature_inherited' => false,
        ]);
        DB::table('chart_of_accounts')->where('code', '4')->update([
            'account_type' => 'income',
            'account_nature' => 'credit',
            'is_nature_inherited' => false,
        ]);
        DB::table('chart_of_accounts')->where('code', '5')->update([
            'account_type' => 'equity',
            'account_nature' => 'credit',
            'is_nature_inherited' => false,
        ]);

        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('chart_of_accounts', function (Blueprint $table) {
                $table->dropForeign(['parent_id']);
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('chart_of_accounts')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('chart_of_accounts', function (Blueprint $table) {
                $table->dropForeign(['parent_id']);
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('chart_of_accounts')
                    ->cascadeOnDelete();
            });
        }

        Schema::table('chart_of_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('chart_of_accounts', 'is_nature_inherited')) {
                $table->dropColumn('is_nature_inherited');
            }
            if (Schema::hasColumn('chart_of_accounts', 'account_nature')) {
                $table->dropColumn('account_nature');
            }
            if (Schema::hasColumn('chart_of_accounts', 'account_type')) {
                $table->dropColumn('account_type');
            }
            if (Schema::hasColumn('chart_of_accounts', 'name_en')) {
                $table->dropColumn('name_en');
            }
        });
    }
};
