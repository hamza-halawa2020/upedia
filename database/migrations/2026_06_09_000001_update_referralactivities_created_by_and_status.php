<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('referralactivities', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });

        DB::statement("ALTER TABLE `referralactivities` MODIFY `status` ENUM('not_active', 'active') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `referralactivities` MODIFY `status` ENUM('not_active', 'active') NOT NULL DEFAULT 'not_active'");

        Schema::table('referralactivities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
