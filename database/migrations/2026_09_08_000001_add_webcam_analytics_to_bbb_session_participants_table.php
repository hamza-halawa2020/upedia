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
            if (! Schema::hasColumn('bbb_session_participants', 'webcam_opened_at')) {
                $table->timestamp('webcam_opened_at')->nullable()->after('has_video');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_closed_at')) {
                $table->timestamp('webcam_closed_at')->nullable()->after('webcam_opened_at');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_total_seconds')) {
                $table->unsignedBigInteger('webcam_total_seconds')->default(0)->after('webcam_closed_at');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_open_count')) {
                $table->unsignedBigInteger('webcam_open_count')->default(0)->after('webcam_total_seconds');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_stream_id')) {
                $table->string('webcam_stream_id')->nullable()->after('webcam_open_count');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_active_streams')) {
                $table->json('webcam_active_streams')->nullable()->after('webcam_stream_id');
            }

            if (! Schema::hasColumn('bbb_session_participants', 'webcam_events')) {
                $table->json('webcam_events')->nullable()->after('webcam_active_streams');
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
                'webcam_events',
                'webcam_active_streams',
                'webcam_stream_id',
                'webcam_open_count',
                'webcam_total_seconds',
                'webcam_closed_at',
                'webcam_opened_at',
            ] as $column) {
                if (Schema::hasColumn('bbb_session_participants', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
