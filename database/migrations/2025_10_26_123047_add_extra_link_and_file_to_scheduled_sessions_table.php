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
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            $table->string('extra_link')->nullable()->after('end_time');
            $table->string('extra_file')->nullable()->after('extra_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            $table->dropColumn('extra_file');
            $table->dropColumn('extra_link');
        });
    }
};
