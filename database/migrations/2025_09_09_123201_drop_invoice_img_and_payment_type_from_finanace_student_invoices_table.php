<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_img', 'payment_type']);
        });
    }
    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->string('invoice_img')->nullable()->after('some_existing_column');
            $table->enum('payment_type', ['instapay', 'online'])->nullable()->after('invoice_img');
        });
    }
};
