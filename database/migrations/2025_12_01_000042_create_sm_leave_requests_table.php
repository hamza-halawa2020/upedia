<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->date('apply_date')->nullable();
            $table->date('leave_from')->nullable();
            $table->date('leave_to')->nullable();
            $table->text('reason')->nullable();
            $table->text('note')->nullable();
            $table->string('file')->nullable();
            $table->string('approve_status')->nullable()->comment('P for Pending, A for Approve, R for reject');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->unsignedBigInteger('leave_define_id')->nullable()->unsigned();
            $table->foreign('leave_define_id')->references('id')->on('sm_leave_defines')->onDelete('cascade');

            $table->unsignedBigInteger('staff_id')->nullable()->unsigned();
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('type_id')->nullable()->unsigned();
            $table->foreign('type_id')->references('id')->on('sm_leave_types')->onDelete('cascade');

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
        Schema::dropIfExists('sm_leave_requests');
    }
}
