<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class SmBaseSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseSetups = [
            [
                'id' => 1,
                'base_setup_name' => 'Male',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'base_group_id' => 1,
                'school_id' => 1,
            ],
            [
                'id' => 2,
                'base_setup_name' => 'Female',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'base_group_id' => 1,
                'school_id' => 1,
            ],
        ];

        foreach ($baseSetups as $baseSetup) {
            $baseSetup['base_group_id'] = $this->baseGroupId($baseSetup['base_group_id']);

            if (! Schema::hasColumn('sm_base_setups', 'school_id')) {
                unset($baseSetup['school_id']);
            }

            $baseSetup['created_at'] = now();
            $baseSetup['updated_at'] = now();

            DB::table('sm_base_setups')->updateOrInsert(
                ['id' => $baseSetup['id']],
                $baseSetup
            );
        }
    }

    private function baseGroupId(int $baseGroupId): int
    {
        $baseGroup = DB::table('sm_base_groups')->where('id', $baseGroupId)->first();

        if (! $baseGroup) {
            throw new RuntimeException("Base group {$baseGroupId} was not found.");
        }

        return $baseGroup->id;
    }
}
