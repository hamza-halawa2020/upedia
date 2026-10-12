<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmHourlyRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_hourly_rates', function (Blueprint $table) {
            $table->id();
            $table->string('grade')->nullable();
            $table->integer('rate')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

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
        Schema::dropIfExists('sm_hourly_rates');
    }
}
