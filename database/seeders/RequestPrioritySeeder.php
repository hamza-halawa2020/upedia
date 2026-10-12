<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [1, 'high'],
            [2, 'medium'],
            [3, 'low'],
        ];

        foreach ($priorities as [$id, $name]) {
            DB::table('request_priorities')->updateOrInsert(
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
