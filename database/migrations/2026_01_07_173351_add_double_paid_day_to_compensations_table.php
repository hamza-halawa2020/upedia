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
        Schema::table('compensations', function (Blueprint $table) {
            $table->boolean('double_paid_day')->nullable();
            $table->foreignIdFor(\App\Models\HrHolidayStaff::class)->nullable();
            $table->foreignIdFor(\App\Models\Rule::class , 'rule_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {

        });
    }
};
