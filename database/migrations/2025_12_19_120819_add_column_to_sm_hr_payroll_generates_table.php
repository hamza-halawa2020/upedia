<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sm_hr_payroll_generates', function (Blueprint $table) {
            $table->unsignedBigInteger('payroll_invoice_id')->nullable();
            $table->foreign('payroll_invoice_id')->references('id')->on('hr_payroll_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_hr_payroll_generates', function (Blueprint $table) {
            $table->dropColumn('payroll_invoice_id');
        });
    }
};
