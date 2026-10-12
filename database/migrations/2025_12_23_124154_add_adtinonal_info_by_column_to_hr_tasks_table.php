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
        Schema::table('hr_tasks', function (Blueprint $table) {
            $table->longText("additional_info")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_regularizations_permissions', function (Blueprint $table) {
            $table->dropColumn('additional_info');
        });
    }
};
