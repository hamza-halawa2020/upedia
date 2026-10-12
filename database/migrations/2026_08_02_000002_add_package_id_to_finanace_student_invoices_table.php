<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (! Schema::hasColumn('finanace_student_invoices', 'package_id')) {
                $table->foreignId('package_id')
                    ->nullable()
                    ->after('product_id')
                    ->constrained('packages')
                    ->nullOnDelete()
                    ->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('finanace_student_invoices', 'package_id')) {
                $table->dropConstrainedForeignId('package_id');
            }
        });
    }
};
