<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('invoice_id');
            $table->string('paypal_order_id')->unique();
            $table->double('amount',10.2);
            $table->char('currency',10);
            $table->string('reason')->nullable();
            $table->enum('status',['pending','created','paid','faild','canceled','rejected']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
