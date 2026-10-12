<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->json('ec_level_ids')->nullable()->after('track_level_id')
                ->comment('English Club: the two adjacent track level IDs selected at booking time');
        });
    }

    public function down(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->dropColumn('ec_level_ids');
        });
    }
};
