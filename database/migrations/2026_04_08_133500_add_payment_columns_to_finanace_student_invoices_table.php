<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('finanace_student_invoices', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('deposite');
            }

            if (! Schema::hasColumn('finanace_student_invoices', 'invoice_img')) {
                $table->json('invoice_img')->nullable()->after('payment_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('finanace_student_invoices', 'invoice_img')) {
                $table->dropColumn('invoice_img');
            }

            if (Schema::hasColumn('finanace_student_invoices', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });
    }
};
