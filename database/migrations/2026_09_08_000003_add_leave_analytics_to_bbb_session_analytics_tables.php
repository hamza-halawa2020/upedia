<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bbb_session_participants')) {
            Schema::table('bbb_session_participants', function (Blueprint $table) {
                if (! Schema::hasColumn('bbb_session_participants', 'left_at')) {
                    $table->timestamp('left_at')->nullable()->after('last_seen_at');
                }

                if (! Schema::hasColumn('bbb_session_participants', 'attendance_total_seconds')) {
                    $table->unsignedBigInteger('attendance_total_seconds')->default(0)->after('left_at');
                }
            });
        }

        if (Schema::hasTable('bbb_session_join_logs')) {
            Schema::table('bbb_session_join_logs', function (Blueprint $table) {
                if (! Schema::hasColumn('bbb_session_join_logs', 'left_at')) {
                    $table->timestamp('left_at')->nullable()->after('joined_at');
                }

                if (! Schema::hasColumn('bbb_session_join_logs', 'duration_seconds')) {
                    $table->unsignedBigInteger('duration_seconds')->default(0)->after('left_at');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bbb_session_join_logs')) {
            Schema::table('bbb_session_join_logs', function (Blueprint $table) {
                foreach (['duration_seconds', 'left_at'] as $column) {
                    if (Schema::hasColumn('bbb_session_join_logs', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('bbb_session_participants')) {
            Schema::table('bbb_session_participants', function (Blueprint $table) {
                foreach (['attendance_total_seconds', 'left_at'] as $column) {
                    if (Schema::hasColumn('bbb_session_participants', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
