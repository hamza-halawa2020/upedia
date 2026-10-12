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
        Schema::table('sm_students', function (Blueprint $table) {
            $table->string('mobile_country_code')->nullable()->after('mobile');
            $table->string('another_mobile_country_code')->nullable()->after('another_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->dropColumn('mobile_country_code');
            $table->dropColumn('another_mobile_country_code');
        });
    }
};
