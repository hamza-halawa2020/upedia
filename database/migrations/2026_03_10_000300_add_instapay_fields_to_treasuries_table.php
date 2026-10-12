<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            if (!Schema::hasColumn('treasuries', 'has_insta_pay')) {
                $table->boolean('has_insta_pay')->default(false)->after('account_number');
            }

            if (!Schema::hasColumn('treasuries', 'insta_pay_phone')) {
                $table->string('insta_pay_phone', 30)->nullable()->after('has_insta_pay');
            }
        });
    }

    public function down(): void
    {
        Schema::table('treasuries', function (Blueprint $table) {
            if (Schema::hasColumn('treasuries', 'insta_pay_phone')) {
                $table->dropColumn('insta_pay_phone');
            }
            if (Schema::hasColumn('treasuries', 'has_insta_pay')) {
                $table->dropColumn('has_insta_pay');
            }
        });
    }
};
