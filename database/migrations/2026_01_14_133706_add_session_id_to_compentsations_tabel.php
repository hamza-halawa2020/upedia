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
        Schema::table('compensations', function (Blueprint $table) {
            $table->foreignIdFor(
                \App\Models\ScheduledSession::class ,
                'staff_schedule_session_id')
                ->nullable()
                ->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn(['staff_schedule_session_id']);
        });
    }
};
