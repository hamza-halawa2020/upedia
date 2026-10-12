<?php

use App\Models\StudentInvoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('purchase_details') || Schema::hasColumn('purchase_details', 'student_invoice_id')) {
            return;
        }

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->foreignIdFor(StudentInvoice::class)->nullable()->after('course_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('purchase_details') || !Schema::hasColumn('purchase_details', 'student_invoice_id')) {
            return;
        }

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropConstrainedForeignId('student_invoice_id');
        });
    }
};
