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
        Schema::table('firebase_notification_configs', function (Blueprint $table) {
            $table->integer('working_hour_start')->default(8)->after('second_notification_after');
            $table->integer('working_hour_end')->default(16)->after('working_hour_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('firebase_notification_configs', function (Blueprint $table) {
            $table->dropColumn(['working_hour_start', 'working_hour_end']);
        });
    }
};
