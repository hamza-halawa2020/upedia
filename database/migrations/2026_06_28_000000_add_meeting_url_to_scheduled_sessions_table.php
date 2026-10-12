<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('scheduled_sessions', 'meeting_url')) {
                $table->string('meeting_url')->nullable()->after('end_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('scheduled_sessions', 'meeting_url')) {
                $table->dropColumn('meeting_url');
            }
        });
    }
};
