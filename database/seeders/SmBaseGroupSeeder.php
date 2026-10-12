<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmBaseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseGroups = [
            [
                'id' => 1,
                'name' => 'Gender',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Religion',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Blood Group',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
            ],
        ];

        foreach ($baseGroups as $baseGroup) {
            $baseGroup['created_at'] = now();
            $baseGroup['updated_at'] = now();

            DB::table('sm_base_groups')->updateOrInsert(
                ['id' => $baseGroup['id']],
                $baseGroup
            );
        }
    }
}
