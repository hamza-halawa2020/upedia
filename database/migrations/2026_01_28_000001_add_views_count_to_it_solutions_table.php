<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('it_solutions', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0)->after('keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('it_solutions', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });
    }
};
