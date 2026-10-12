<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            DB::statement("ALTER TABLE finanace_student_invoices MODIFY COLUMN payment_status ENUM ('paid', 'not_paid','refunded','paid_purchased','deposite','paid_deposite') DEFAULT 'not_paid'");            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            DB::statement("ALTER TABLE finanace_student_invoices MODIFY COLUMN payment_status ENUM ('paid', 'not_paid','refunded','paid_purchased','deposite','paid_deposite') DEFAULT 'not_paid'");            

        });
    }
};
