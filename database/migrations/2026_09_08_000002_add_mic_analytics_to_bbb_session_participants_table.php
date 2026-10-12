<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bbb_session_participants')) {
            return;
        }

        Schema::table('bbb_session_participants', function (Blueprint $table) {
            if (! Schema::hasColumn('bbb_session_participants', 'mic_opened_at')) {
                $table->timestamp('mic_opened_at')->nullable()->after('has_joined_voice');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_closed_at')) {
                $table->timestamp('mic_closed_at')->nullable()->after('mic_opened_at');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_total_seconds')) {
                $table->unsignedBigInteger('mic_total_seconds')->default(0)->after('mic_closed_at');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_open_count')) {
                $table->unsignedBigInteger('mic_open_count')->default(0)->after('mic_total_seconds');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_is_muted')) {
                $table->boolean('mic_is_muted')->default(false)->after('mic_open_count');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_muted_at')) {
                $table->timestamp('mic_muted_at')->nullable()->after('mic_is_muted');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_unmuted_at')) {
                $table->timestamp('mic_unmuted_at')->nullable()->after('mic_muted_at');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'mic_events')) {
                $table->json('mic_events')->nullable()->after('mic_unmuted_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('bbb_session_participants')) {
            return;
        }

        Schema::table('bbb_session_participants', function (Blueprint $table) {
            foreach ([
                'mic_events',
                'mic_unmuted_at',
                'mic_muted_at',
                'mic_is_muted',
                'mic_open_count',
                'mic_total_seconds',
                'mic_closed_at',
                'mic_opened_at',
            ] as $column) {
                if (Schema::hasColumn('bbb_session_participants', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
