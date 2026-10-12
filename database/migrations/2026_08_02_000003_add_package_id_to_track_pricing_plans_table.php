<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->after('pricing_plan_type_id');

            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->nullOnDelete();

            $table->unique(
                ['track_id', 'track_type_id', 'pricing_plan_type_id', 'package_id'],
                'track_pricing_unique_combination'
            );
        });
    }

    public function down(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropUnique('track_pricing_unique_combination');
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
