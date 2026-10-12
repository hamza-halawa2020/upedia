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
        Schema::table('sm_human_departments', function (Blueprint $table) {
            $table->enum('can_delete', ['yes', 'no'])->after('slug')->default('yes');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_human_departments', function (Blueprint $table) {
            $table->dropColumn('can_delete');
        });
    }
};
