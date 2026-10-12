<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_holidays', function (Blueprint $table) {
            $table->id();
            $table->string('holiday_title', 200)->nullable();
            $table->string('details', 500)->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('upload_image_file', 200)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->unsignedBigInteger('created_by')->nullable()->default(1)->unsigned();

            $table->unsignedBigInteger('updated_by')->nullable()->default(1)->unsigned();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_holidays');
    }
}
