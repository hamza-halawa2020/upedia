<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'id' => 1,
                'title' => 'Freelancer',
                'active_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => null,
                'updated_by' => null,
                'is_saas' => 0,
            ],
            [
                'id' => 2,
                'title' => 'Part-time',
                'active_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => null,
                'updated_by' => null,
                'is_saas' => 0,
            ],
            [
                'id' => 3,
                'title' => 'Full-time',
                'active_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => null,
                'updated_by' => null,
                'is_saas' => 0,
            ],
        ];

        foreach ($types as $type) {
            DB::table('em_types')->updateOrInsert(
                ['id' => $type['id']],
                $type,
            );
        }
    }
}
