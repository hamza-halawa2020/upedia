<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmLeaveDefinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_leave_defines', function (Blueprint $table) {
            $table->id();
            $table->integer('days')->nullable()->unsigned();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->unsignedBigInteger('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('type_id')->nullable()->unsigned();
            $table->foreign('type_id')->references('id')->on('sm_leave_types')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable()->default(1)->unsigned();
            $table->unsignedBigInteger('updated_by')->nullable()->default(1)->unsigned();

            $table->unsignedBigInteger('total_days')->nullable()->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_leave_defines');
    }
}
