<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('track_pricing_plans', 'teacher_type')) {
            Schema::table('track_pricing_plans', function (Blueprint $table) {
                $table->string('teacher_type')->default('native_like')->after('package_id');
            });
        }

        DB::table('track_pricing_plans')
            ->whereNull('teacher_type')
            ->orWhere('teacher_type', '')
            ->update(['teacher_type' => 'native_like']);

        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_track_id_index', ['track_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_track_type_id_index', ['track_type_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_pricing_plan_type_id_index', ['pricing_plan_type_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_package_id_index', ['package_id']);

        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropUnique('track_pricing_unique_combination');

            $table->unique(
                ['track_id', 'track_type_id', 'pricing_plan_type_id', 'package_id', 'teacher_type'],
                'track_pricing_unique_combination'
            );
        });
    }

    public function down(): void
    {
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_track_id_index', ['track_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_track_type_id_index', ['track_type_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_pricing_plan_type_id_index', ['pricing_plan_type_id']);
        $this->ensureIndex('track_pricing_plans', 'track_pricing_plans_package_id_index', ['package_id']);

        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropUnique('track_pricing_unique_combination');

            $table->unique(
                ['track_id', 'track_type_id', 'pricing_plan_type_id', 'package_id'],
                'track_pricing_unique_combination'
            );
        });
    }

    private function ensureIndex(string $table, string $indexName, array $columns): void
    {
        if ($this->indexExists($table, $indexName)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($indexName, $columns) {
            $table->index($columns, $indexName);
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        return ! empty(DB::select(
            'SHOW INDEX FROM ' . $table . ' WHERE Key_name = ?',
            [$indexName]
        ));
    }
};
