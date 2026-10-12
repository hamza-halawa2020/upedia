<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SmProductPurchase;
class CreateSmProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_product_purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->date('expaire_date'); 
            $table->float('price', 10, 2)->nullable(); 
            $table->float('paid_amount', 10, 2)->nullable();
            $table->float('due_amount', 10, 2)->nullable();
            $table->string('package', 10, 2)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('staff_id')->nullable()->unsigned();
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');

            
        });
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_product_purchases');
    }
}
