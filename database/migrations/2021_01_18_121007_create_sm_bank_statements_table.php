<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_bank_statements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('after_balance')->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->string('type')->length(11)->nullable()->comment('1 for Income 0 for Expense');

            $table->unsignedBigInteger('payment_method')->nullable()->unsigned();
            
            $table->string('details')->length(500)->nullable();
            $table->unsignedBigInteger('item_receive_id')->nullable();
            $table->unsignedBigInteger('item_receive_bank_statement_id')->nullable();
            $table->unsignedBigInteger('item_sell_bank_statement_id')->nullable();
            $table->unsignedBigInteger('item_sell_id')->nullable();
            $table->date('payment_date')->nullable();
            $table->tinyInteger('active_status')->default(1);

            $table->unsignedBigInteger('fees_payment_id')->nullable();
            $table->unsignedBigInteger('payroll_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_bank_statements');
    }
}
