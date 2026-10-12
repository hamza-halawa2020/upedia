<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->enum('type', ['product', 'track', 'freeze'])->default('product')->change();
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->enum('type', ['product', 'track'])->default('product')->change();
        });
    }
};