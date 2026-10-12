<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escalation_requests', function (Blueprint $table) {
            $table->foreignId('student_request_id')
                ->nullable()
                ->after('to_department_id')
                ->constrained('student_requests')
                ->nullOnDelete();

            $table->index(['student_request_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('escalation_requests', function (Blueprint $table) {
            $table->dropIndex(['student_request_id', 'status']);
            $table->dropConstrainedForeignId('student_request_id');
        });
    }
};
