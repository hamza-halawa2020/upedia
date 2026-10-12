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
            $table->dropUnique('compensation_logs_staff_id_auth_id_unique');
            $table->unique(['staff_id', 'auth_id', 'from_date', 'to_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensation_logs', function (Blueprint $table) {
            $table->dropUnique(['staff_id', 'auth_id', 'from_date', 'to_date']);
            $table->unique(['staff_id', 'auth_id']);
        });
    }
};
