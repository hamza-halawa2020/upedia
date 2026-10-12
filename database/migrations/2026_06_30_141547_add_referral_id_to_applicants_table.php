<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('applicants', 'referral_id')) {
            Schema::table('applicants', function (Blueprint $table) {
                $table->unsignedBigInteger('referral_id')->nullable()->after('assigned_staff_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('referral_id');
        });
    }
};
