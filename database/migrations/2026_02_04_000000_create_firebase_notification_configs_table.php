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
        Schema::create('firebase_notification_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('first_notification_before')->comment('Minutes/Hours before (unit depends on logic, assuming minutes based on typical use or user clarifying "int")');
            $table->integer('second_notification_after')->comment('Minutes/Hours after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firebase_notification_configs');
    }
};
