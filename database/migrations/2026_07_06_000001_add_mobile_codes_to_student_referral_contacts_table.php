<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_referral_contacts', function (Blueprint $table) {
            $table->string('mobile_country_code', 10)->nullable()->after('phone');
            $table->string('mobile_dial_code', 10)->nullable()->after('mobile_country_code');
        });
    }

    public function down(): void
    {
        Schema::table('student_referral_contacts', function (Blueprint $table) {
            $table->dropColumn(['mobile_country_code', 'mobile_dial_code']);
        });
    }
};
