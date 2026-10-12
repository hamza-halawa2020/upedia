<?php

use App\Models\FinanaceStudentInvoice;
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
        Schema::table('course_students', function (Blueprint $table) {
            $table->foreignIdFor(FinanaceStudentInvoice::class, 'finanace_student_invoice_id')->after('course_id')->nullable();
            $table->unique(['course_id', 'student_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_students', function (Blueprint $table) {
            $table->dropColumn('finanace_student_invoice_id');
        });
    }
};
