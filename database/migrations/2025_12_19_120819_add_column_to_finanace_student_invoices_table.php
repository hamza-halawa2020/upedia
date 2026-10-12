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
            $table->unsignedBigInteger('promocode_id')->nullable();
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('net_price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('deposite')->nullable();
            DB::statement("ALTER TABLE finanace_student_invoices MODIFY COLUMN payment_status ENUM ('paid', 'not_paid','refunded','paid_purchased','deposite','rejected') DEFAULT 'not_paid'");            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropColumn('promocode_id');
            $table->dropColumn('discount_type');
            $table->dropColumn('discount');
            $table->dropColumn('net_price');
            $table->dropColumn('total_price');
            $table->dropColumn('deposite');
            DB::statement("ALTER TABLE finanace_student_invoices MODIFY COLUMN payment_status ENUM ('paid', 'not_paid','refunded','paid_purchased','deposite') DEFAULT 'not_paid'");                        

        });
    }
};
