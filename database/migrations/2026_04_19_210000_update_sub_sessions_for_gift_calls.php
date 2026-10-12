<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_sessions', function (Blueprint $table) {
            $table->dropUnique('sub_sessions_scheduled_session_id_unique');
            $table->unsignedBigInteger('student_id')->nullable()->after('status');
            $table->dateTime('start_at')->nullable()->after('student_id');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->unsignedSmallInteger('duration_minutes')->nullable()->after('end_at');
            $table->index(['scheduled_session_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('sub_sessions', function (Blueprint $table) {
            $table->dropIndex('sub_sessions_scheduled_session_id_type_index');
            $table->dropColumn(['student_id', 'start_at', 'end_at', 'duration_minutes']);
            $table->unique('scheduled_session_id');
        });
    }
};
