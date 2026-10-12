<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->unsignedBigInteger('demo_staff_scheduled_id')
                ->nullable()
                ->after('finanace_student_invoice_id')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->dropIndex(['demo_staff_scheduled_id']);
            $table->dropColumn('demo_staff_scheduled_id');
        });
    }
};
