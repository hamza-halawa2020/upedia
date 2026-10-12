<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SmAddIncome;

class CreateSmAddIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_add_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->date('date')->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('item_sell_id')->nullable();
            $table->unsignedBigInteger('fees_collection_id')->nullable();
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->unsignedBigInteger('active_status')->default(1);
            $table->unsignedBigInteger('account_id')->nullable()->unsigned();
            $table->unsignedBigInteger('income_head_id')->nullable()->unsigned();

            $table->foreign('account_id')->references('id')->on('sm_bank_accounts')->onDelete('cascade');

            $table->unsignedBigInteger('payment_method_id')->nullable()->unsigned();
            
            $table->unsignedBigInteger('created_by')->nullable()->default(1)->unsigned();
            
            $table->unsignedBigInteger('updated_by')->nullable()->default(1)->unsigned();
            
            $table->unsignedBigInteger('installment_payment_id')->nullable()->unsigned();
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
        Schema::dropIfExists('sm_add_incomes');
    }
}
