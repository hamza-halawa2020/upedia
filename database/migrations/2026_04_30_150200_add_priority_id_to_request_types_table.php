<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('request_types', function (Blueprint $table) {
            $table->foreignId('priority_id')
                ->nullable()
                ->after('name')
                ->constrained('request_priorities')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('request_types', function (Blueprint $table) {
            $table->dropConstrainedForeignId('priority_id');
        });
    }
};

