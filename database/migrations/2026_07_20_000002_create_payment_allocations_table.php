<?php

use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payment::class)->constrained()->cascadeOnDelete();
            $table->string('allocatable_type');
            $table->unsignedBigInteger('allocatable_id');
            $table->decimal('allocated_amount', 15, 2);
            $table->decimal('remaining_before', 15, 2)->nullable();
            $table->decimal('remaining_after', 15, 2)->nullable();
            $table->boolean('is_reversal')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_allocations');
    }
};
