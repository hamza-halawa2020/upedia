<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->integer('total_days')->nullable()->unsigned();
            $table->tinyInteger('active_status')->default(1);
            $table->integer('max_leaves_allowed')->nullable();
            $table->integer('applicable_after_work_days')->nullable();
            $table->boolean('is_leave_without_pay')->default(false);
            $table->unsignedInteger('created_by')->nullable()->default(1)->unsigned();
            $table->unsignedInteger('updated_by')->nullable()->default(1)->unsigned();
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
        Schema::dropIfExists('sm_leave_types');
    }
}
