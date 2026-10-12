<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmAddExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_add_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->date('date')->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('item_receive_id')->nullable();
            $table->unsignedInteger('inventory_id')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->unsignedInteger('expense_head_id')->nullable();
            // $table->foreign('expense_head_id')->references('id')->on('sm_expense_heads')->onDelete('cascade');

            $table->unsignedInteger('account_id')->nullable();
            // $table->foreign('account_id')->references('id')->on('sm_bank_accounts')->onDelete('cascade');

            $table->unsignedInteger('payment_method_id')->nullable();
            // $table->foreign('payment_method_id')->references('id')->on('sm_payment_methhods')->onDelete('cascade');

            $table->unsignedInteger('payroll_payment_id')->nullable()->default(1)->unsigned();
            $table->unsignedInteger('created_by')->nullable()->default(1)->unsigned();

            $table->unsignedInteger('updated_by')->nullable()->default(1)->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_add_expenses');
    }
}
