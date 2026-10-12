<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->unsignedBigInteger('track_level_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->unsignedBigInteger('track_level_id')->nullable(false)->change();
        });
    }
};
