<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->string('mobile_country_code')->nullable()->after('mobile');
            $table->string('another_mobile')->nullable()->after('mobile_country_code');
            $table->string('another_mobile_country_code')->nullable()->after('another_mobile');
            $table->string('mobile_dial_code')->nullable()->after('another_mobile_country_code');
            $table->string('another_mobile_dial_code')->nullable()->after('mobile_dial_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('mobile_country_code');
            $table->dropColumn('another_mobile');
            $table->dropColumn('another_mobile_country_code');
            $table->dropColumn('mobile_dial_code');
            $table->dropColumn('another_mobile_dial_code');
        });
    }
};
