<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll_finance_syncs', function (Blueprint $table) {
            $table->json('finance_options')->nullable()->after('last_sync_error');
        });
    }

    public function down(): void
    {
        Schema::table('payroll_finance_syncs', function (Blueprint $table) {
            $table->dropColumn('finance_options');
        });
    }
};
