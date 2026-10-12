<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'has_usb_flash',
                'has_bag',
                'has_headphone',
                'has_monitor',
                'has_mouse',
                'has_keyboard',
                'accessories',
            ]);
        });
    }
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->boolean('has_usb_flash')->nullable();
            $table->boolean('has_bag')->nullable();
            $table->boolean('has_headphone')->nullable();
            $table->boolean('has_monitor')->nullable();
            $table->boolean('has_mouse')->nullable();
            $table->boolean('has_keyboard')->nullable();
            $table->json('accessories')->nullable();
        });
    }
};
