<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SmItem;
class CreateSmItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name',100)->nullable();
            $table->float('total_in_stock', 10, 2)->nullable();
            $table->string('description',500)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('item_category_id')->nullable()->unsigned();
            $table->foreign('item_category_id')->references('id')->on('sm_item_categories')->onDelete('cascade');   

        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_items');
    }
}
