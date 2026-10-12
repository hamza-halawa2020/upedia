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
        Schema::table('session_lessons', function (Blueprint $table) {
            $table->dropColumn(['host_type', 'host_path']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_lessons', function (Blueprint $table) {
            $table->string('host_type')->default('youtube');
            $table->string('host_path')->nullable();
        });
    }
};
