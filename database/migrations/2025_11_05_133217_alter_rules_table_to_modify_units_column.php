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
        Schema::table('rules', function (Blueprint $table) {

            Schema::table('rules', function (Blueprint $table) {
                $table->dropColumn('units');
            });

            Schema::table('rules', function (Blueprint $table) {
                $table->string('units')->nullable()->after('value');
            });

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rules', function (Blueprint $table) {
            //
        });
    }
};
