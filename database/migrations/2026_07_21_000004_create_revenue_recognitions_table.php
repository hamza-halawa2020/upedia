<?php

use App\Models\JournalEntry;
use App\Models\StudentInvoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('revenue_recognitions')) {
            return;
        }

        Schema::create('revenue_recognitions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StudentInvoice::class)->constrained()->cascadeOnDelete();
            $table->string('source_service', 80);
            $table->string('external_booking_reference', 120);
            $table->string('external_session_reference', 120);
            $table->decimal('recognized_amount', 15, 2);
            $table->string('currency', 10)->default('EGP');
            $table->timestamp('recognized_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignIdFor(JournalEntry::class)->nullable()->constrained()->nullOnDelete();
            $table->string('idempotency_key')->nullable()->unique();
            $table->timestamps();

            $table->unique(
                ['source_service', 'external_booking_reference', 'external_session_reference'],
                'revenue_recognition_session_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revenue_recognitions');
    }
};
