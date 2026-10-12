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
        Schema::table('hr_rule_levels', function (Blueprint $table) {
            $table->dropUnique(['hr_rule_id', 'level_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_rule_levels', function (Blueprint $table) {
            $table->unique(['hr_rule_id', 'level_number']);
        });
    }
};
