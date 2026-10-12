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
        Schema::table('retention_feedback', function (Blueprint $table) {
            $table->boolean('virtual_background')->default(false)->after('camera_off');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retention_feedback', function (Blueprint $table) {
            $table->dropColumn('virtual_background');
        });
    }
};
