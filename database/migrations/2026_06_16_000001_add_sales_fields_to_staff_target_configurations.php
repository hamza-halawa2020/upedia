<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_target_configuration_groups', function (Blueprint $table) {
            $table->decimal('conv_min_percentage', 5, 2)->nullable()->after('percentage');
            $table->decimal('bonus_conv_percentage', 5, 2)->nullable()->after('conv_min_percentage');
            $table->decimal('bonus_percentage', 5, 2)->nullable()->after('bonus_conv_percentage');
            $table->unsignedTinyInteger('quarter_target')->nullable()->after('bonus_percentage');
            $table->unsignedBigInteger('quarter_total_target')->nullable()->after('quarter_target');
            $table->unsignedBigInteger('quarter_days')->nullable()->default(65)->after('quarter_total_target');
            $table->decimal('daily_target', 10, 2)->nullable()->after('quarter_days');
        });

        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->decimal('conv_min_percentage', 5, 2)->nullable()->after('percentage');
            $table->decimal('bonus_conv_percentage', 5, 2)->nullable()->after('conv_min_percentage');
            $table->decimal('bonus_percentage', 5, 2)->nullable()->after('bonus_conv_percentage');
            $table->unsignedTinyInteger('quarter_target')->nullable()->after('bonus_percentage');
            $table->unsignedBigInteger('quarter_total_target')->nullable()->after('quarter_target');
            $table->unsignedBigInteger('quarter_days')->nullable()->default(65)->after('quarter_total_target');
            $table->decimal('daily_target', 10, 2)->nullable()->after('quarter_days');
        });
    }

    public function down(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'conv_min_percentage',
                'bonus_conv_percentage',
                'bonus_percentage',
                'quarter_target',
                'quarter_total_target',
                'quarter_days',
                'daily_target',
            ]);
        });

        Schema::table('staff_target_configuration_groups', function (Blueprint $table) {
            $table->dropColumn([
                'conv_min_percentage',
                'bonus_conv_percentage',
                'bonus_percentage',
                'quarter_target',
                'quarter_total_target',
                'quarter_days',
                'daily_target',
            ]);
        });
    }
};
