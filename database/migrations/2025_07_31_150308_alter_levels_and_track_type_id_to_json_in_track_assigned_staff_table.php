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
        Schema::table('track_assigned_staff', function (Blueprint $table) {
            $table->json('levels')->nullable()->change();
            $table->json('track_type_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('track_assigned_staff', function (Blueprint $table) {
            $table->string('levels')->nullable()->change();
            $table->string('track_type_id')->nullable()->change();
        });
    }
};
