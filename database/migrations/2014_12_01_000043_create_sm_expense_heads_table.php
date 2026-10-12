<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmExpenseHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_expense_heads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->unsignedBigInteger('created_by')->nullable()->default(1);

            $table->unsignedBigInteger('updated_by')->nullable()->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_expense_heads');
    }
}
