<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_placement_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_test_booking_id')->constrained('placement_test_bookings')->cascadeOnDelete();
            $table->string('external_id')->nullable()->index();
            $table->string('token')->nullable();
            $table->text('link')->nullable();
            $table->string('status')->nullable()->index();
            $table->json('result')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->unique('placement_test_booking_id', 'ai_attempt_unique_booking');
        });

    }

    public function down(): void
    {
        // Keep rollback conservative: do not recreate the old columns automatically.
    }
};
