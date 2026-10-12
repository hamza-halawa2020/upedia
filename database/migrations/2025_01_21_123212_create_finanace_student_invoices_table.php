<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finanace_student_invoices', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('staff_scheduleds_id')->nullable();
            $table->integer('student_id');
            $table->integer('levels_id')->nullable();
            $table->string('invoice_number');
            $table->string('staff_scheduleds_status')->default('reserved');
            // Use ENUM for payment_status
            $table->enum('payment_status', ['paid', 'not_paid', 'refunded','paid_purchased'])->default('not_paid');
            // Use ENUM for bill_status
            $table->enum('bill_status', ['pending', 'billed', 'cancelled'])->default('pending');
            $table->integer('delivery_note')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finanace_student_invoices');
    }
};
