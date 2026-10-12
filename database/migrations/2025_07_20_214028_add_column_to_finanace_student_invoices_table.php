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
            
            // $table->json('invoice_img')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_img');
        });
    }
};
