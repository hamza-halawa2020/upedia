<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escalation_requests', function (Blueprint $table) {
            $table->foreignId('hr_request_id')
                ->nullable()
                ->after('student_request_id')
                ->constrained('hr_requests')
                ->nullOnDelete();

            $table->index(['hr_request_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('escalation_requests', function (Blueprint $table) {
            $table->dropIndex(['hr_request_id', 'status']);
            $table->dropConstrainedForeignId('hr_request_id');
        });
    }
};
