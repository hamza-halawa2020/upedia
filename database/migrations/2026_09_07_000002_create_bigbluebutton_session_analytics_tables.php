<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bbb_session_participants')) {
            Schema::create('bbb_session_participants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('scheduled_session_id')->constrained('scheduled_sessions')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('bbb_user_id')->nullable();
                $table->string('display_name')->nullable();
                $table->string('role')->nullable();
                $table->string('profile_type')->nullable();
                $table->timestamp('first_joined_at')->nullable();
                $table->timestamp('last_joined_at')->nullable();
                $table->timestamp('last_seen_at')->nullable();
                $table->unsignedBigInteger('join_count')->default(0);
                $table->boolean('is_online')->default(false);
                $table->boolean('is_presenter')->default(false);
                $table->boolean('is_listening_only')->default(false);
                $table->boolean('has_joined_voice')->default(false);
                $table->boolean('has_video')->default(false);
                $table->json('raw_attendee')->nullable();
                $table->timestamps();

                $table->unique(['scheduled_session_id', 'bbb_user_id'], 'bbb_session_participants_session_bbb_user_unique');
            });
        }

        if (! Schema::hasTable('bbb_session_join_logs')) {
            Schema::create('bbb_session_join_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('scheduled_session_id')->constrained('scheduled_sessions')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('bbb_user_id')->nullable()->index();
                $table->string('display_name')->nullable();
                $table->string('role')->nullable();
                $table->timestamp('joined_at')->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bbb_session_join_logs');
        Schema::dropIfExists('bbb_session_participants');
    }
};
