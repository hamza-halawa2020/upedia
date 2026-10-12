<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->date('preferred_exam_date')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->dropColumn('preferred_exam_date');
        });
    }
};
