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
        Schema::table('staff_emergency_contact', function (Blueprint $table) {
            $table->string('emergency_relationship')->nullable()->change();
            $table->string('emergency_mobile')->nullable()->change();
            $table->string('emergency_home_telephone')->nullable()->change();
            $table->string('emergency_work_telephone')->nullable()->change();
            $table->string('emergency_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_emergency_contact', function (Blueprint $table) {
            $table->string('emergency_relationship')->change();
            $table->string('emergency_mobile')->change();
            $table->string('emergency_home_telephone')->change();
            $table->string('emergency_work_telephone')->change();
            $table->string('emergency_name')->change();
        });
    }
};
