<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['id' => 1, 'level_number' => 1],
            ['id' => 2, 'level_number' => 2],
            ['id' => 3, 'level_number' => 3],
            ['id' => 4, 'level_number' => 4],
            ['id' => 5, 'level_number' => 5],
            ['id' => 6, 'level_number' => 6],
            ['id' => 7, 'level_number' => 7],
            ['id' => 8, 'level_number' => 8],
            ['id' => 9, 'level_number' => 9],
            ['id' => 10, 'level_number' => 10],
        ];

        foreach ($levels as $level) {
            $level['created_at'] = now();
            $level['updated_at'] = now();

            DB::table('levels')->updateOrInsert(
                ['id' => $level['id']],
                $level
            );
        }
    }
}
