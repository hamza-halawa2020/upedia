<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('referral_settings', function (Blueprint $table) {
            $table->decimal('referrer_discount', 10, 2)->default(0)->after('id');
            $table->decimal('referred_discount', 10, 2)->default(0)->after('referrer_discount');
            $table->foreignId('created_by')->nullable()->after('discount_type')->constrained('users')->nullOnDelete();
        });

        DB::table('referral_settings')->update([
            'referrer_discount' => DB::raw('discount'),
            'referred_discount' => DB::raw('discount'),
        ]);

        Schema::table('referralactivities', function (Blueprint $table) {
            $table->timestamp('referred_discount_used_at')->nullable()->after('is_used');
        });
    }

    public function down(): void
    {
        Schema::table('referralactivities', function (Blueprint $table) {
            $table->dropColumn('referred_discount_used_at');
        });

        Schema::table('referral_settings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn(['referrer_discount', 'referred_discount']);
        });
    }
};
