<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->decimal('level_price', 10, 2)->default(0)->after('price');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('level_price');
        });
    }

    public function down(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropColumn(['level_price', 'discount_percentage']);
        });
    }
};
