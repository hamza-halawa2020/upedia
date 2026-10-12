<?php

use App\Models\PayrollRun;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_finance_syncs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PayrollRun::class)->unique()->constrained()->cascadeOnDelete();
            $table->string('external_journal_entry_id')->nullable();
            $table->enum('sync_status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('synced_at')->nullable();
            $table->text('last_sync_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_finance_syncs');
    }
};
