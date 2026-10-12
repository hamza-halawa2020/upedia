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
        Schema::table('crm_calls', function (Blueprint $table) {
            $table->timestamp('schedule_call_time')->nullable()->after('call_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_calls', function (Blueprint $table) {
            $table->dropColumn('schedule_call_time');
        });
    }
};
