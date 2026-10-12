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
        Schema::table('sm_staff_attendences', function (Blueprint $table) {
            $table->time('check_in')->nullable()->after('attendence_date');
            $table->time('check_out')->nullable()->after('check_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staff_attendences', function (Blueprint $table) {
            $table->dropColumn('check_in');
            $table->dropColumn('check_out');
        });
    }
};
