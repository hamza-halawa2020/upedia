<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmBankPaymentSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_bank_payment_slips', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->float('amount', 10, 2)->nullable();
            $table->string('slip')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->unsignedBigInteger('approve_status')->default(0)->comment('0 pending, 1 approve');
            $table->string('payment_mode')->comment('Bk= bank, Cq=Cheque');
            $table->text('reason')->nullable();

            $table->unsignedBigInteger('fees_discount_id')->nullable()->unsigned();
            // $table->foreign('fees_discount_id')->references('id')->on('sm_fees_discounts')->onDelete('restrict');

            $table->unsignedBigInteger('fees_type_id')->nullable()->unsigned();
            // $table->foreign('fees_type_id')->references('id')->on('sm_fees_types')->onDelete('restrict');
            $table->unsignedBigInteger('record_id')->nullable()->unsigned();
            $table->unsignedBigInteger('student_id')->nullable()->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');

            $table->unsignedBigInteger('class_id')->nullable()->unsigned();
            // $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');

            $table->unsignedBigInteger('assign_id')->nullable()->unsigned();
            // $table->foreign('assign_id')->references('id')->on('sm_fees_assigns')->onDelete('cascade');

            $table->unsignedBigInteger('section_id')->nullable()->unsigned();
            // $table->foreign('section_id')->references('id')->on('sm_sections')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable()->default(1)->unsigned();

            $table->unsignedBigInteger('updated_by')->nullable()->default(1)->unsigned();
            
            $table->unsignedBigInteger('child_payment_id')->nullable();
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('active_status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_bank_payment_slips');
    }
}