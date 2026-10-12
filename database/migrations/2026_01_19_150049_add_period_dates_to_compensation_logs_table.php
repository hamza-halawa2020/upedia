<?php

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
        Schema::table('compensation_logs', function (Blueprint $table) {
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensation_logs', function (Blueprint $table) {
            $table->dropColumn(['from_date', 'to_date']);
        });
    }
};
