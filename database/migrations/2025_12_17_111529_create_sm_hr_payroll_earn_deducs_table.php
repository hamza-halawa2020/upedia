<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmHrPayrollEarnDeducsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_hr_payroll_earn_deducs', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->string('earn_dedc_type')->length(5)->nullable()->comment('e for earnings and d for deductions');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();



            $table->unsignedBigInteger('payroll_generate_id')->nullable()->unsigned();
            $table->foreign('payroll_generate_id')->references('id')->on('sm_hr_payroll_generates')->onDelete('cascade');

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
        Schema::dropIfExists('sm_hr_payroll_earn_deducs');
    }
}
