<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [1, 'B2B'],
            [2, 'Family'],
            [3, 'B2C'],
        ];

        foreach ($types as [$id, $name]) {
            DB::table('pricing_plan_types')->updateOrInsert(
                ['id' => $id],
                [
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
