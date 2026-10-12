<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments')) {
            return;
        }

        if (!Schema::hasColumn('payments', 'approval_status')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('approval_status', 20)->default('pending')->index();
            });

            return;
        }

        DB::table('payments')
            ->whereNull('approval_status')
            ->update(['approval_status' => 'pending']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY approval_status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('payments') || !Schema::hasColumn('payments', 'approval_status')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE payments MODIFY approval_status VARCHAR(20) NULL DEFAULT NULL');
        }
    }
};
