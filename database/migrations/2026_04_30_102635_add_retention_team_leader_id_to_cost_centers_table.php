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
        Schema::table('cost_centers', function (Blueprint $table) {
            $table->unsignedBigInteger('retention_team_leader_id')->nullable();
            $table->unsignedBigInteger('retention_staff_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cost_centers', function (Blueprint $table) {
             $table->dropColumn('retention_team_leader_id');
             $table->dropColumn('retention_staff_id');
        });
    }
};
