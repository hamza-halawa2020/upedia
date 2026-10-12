<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            if (! Schema::hasColumn('scheduled_sessions', 'bbb_meeting_id')) {
                $table->string('bbb_meeting_id')->nullable()->unique()->after('meeting_url');
            }

            if (! Schema::hasColumn('scheduled_sessions', 'bbb_internal_meeting_id')) {
                $table->string('bbb_internal_meeting_id')->nullable()->after('bbb_meeting_id');
            }

            if (! Schema::hasColumn('scheduled_sessions', 'bbb_status')) {
                $table->string('bbb_status')->nullable()->after('bbb_internal_meeting_id');
            }

            if (! Schema::hasColumn('scheduled_sessions', 'bbb_started_at')) {
                $table->timestamp('bbb_started_at')->nullable()->after('bbb_status');
            }

            if (! Schema::hasColumn('scheduled_sessions', 'bbb_ended_at')) {
                $table->timestamp('bbb_ended_at')->nullable()->after('bbb_started_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            foreach ([
                'bbb_ended_at',
                'bbb_started_at',
                'bbb_status',
                'bbb_internal_meeting_id',
                'bbb_meeting_id',
            ] as $column) {
                if (Schema::hasColumn('scheduled_sessions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
