<?php

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\Payment;
use App\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_no')->unique();
            $table->date('payment_date');
            $table->string('direction', 20)->index();
            $table->string('source_type', 20)->index();
            $table->string('status', 20)->default('draft')->index();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('EGP');
            $table->foreignIdFor(ChartOfAccount::class, 'from_account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(ChartOfAccount::class, 'to_account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('party_type', 20)->index();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->string('party_name');
            $table->string('party_ref')->nullable();
            $table->string('reference_no')->nullable()->index();
            $table->text('notes')->nullable();
            $table->foreignIdFor(JournalEntry::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamp('posted_at')->nullable();
            $table->foreignIdFor(Payment::class, 'reversed_payment_id')->nullable()->constrained()->nullOnDelete();
            $table->text('reversal_reason')->nullable();
            $table->string('idempotency_key')->nullable()->unique();
            $table->foreignIdFor(Staff::class, 'created_by')->nullable();
            $table->foreignIdFor(Staff::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
