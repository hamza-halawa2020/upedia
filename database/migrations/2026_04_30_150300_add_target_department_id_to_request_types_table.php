<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('request_types', function (Blueprint $table) {
            $table->foreignId('target_department_id')
                ->nullable()
                ->after('priority_id')
                ->constrained('sm_human_departments')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('request_types', function (Blueprint $table) {
            $table->dropConstrainedForeignId('target_department_id');
        });
    }
};

