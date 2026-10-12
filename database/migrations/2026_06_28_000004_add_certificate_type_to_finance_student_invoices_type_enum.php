<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE finanace_student_invoices MODIFY type ENUM('track', 'product', 'freeze', 'certificate') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE finanace_student_invoices MODIFY type ENUM('track', 'product','freeze') NULL");
    }
};
