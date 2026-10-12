<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->date('due_date')->nullable();
            $table->enum('payment_method', ['petty_cash', 'finance_team']);
            $table->enum('status', ['paid', 'open', 'pending_approval']);
            $table->enum('recurring', ['one_time', 'monthly', 'yearly'])->default('one_time');
            $table->text('vendors');
            $table->string('item_name');
            $table->unsignedBigInteger('expense_head_id')->nullable();
            $table->timestamps();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('expense_head_id')
                ->references('id')
                ->on('sm_expense_heads')
                ->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['expense_head_id']);
        });
        Schema::dropIfExists('expenses');
    }
};
