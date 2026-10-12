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
            $table->dropColumn('penalty_type');
            $table->enum('penalty_type', ['warning', 'money', 'days', 'hours', "double_the_previous" , 'termination'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_rule_levels', function (Blueprint $table) {
            //
        });
    }
};
