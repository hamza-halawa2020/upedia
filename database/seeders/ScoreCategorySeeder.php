<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoreCategories = [
            [
                'id' => 1,
                'name' => 'Facilitation skills',
            ],
            [
                'id' => 2,
                'name' => 'Delivery',
            ],
            [
                'id' => 3,
                'name' => 'Language skills of the trainer',
            ],
            [
                'id' => 4,
                'name' => "Trainer's Personality",
            ],
        ];

        foreach ($scoreCategories as $scoreCategory) {
            $scoreCategory['created_at'] = now();
            $scoreCategory['updated_at'] = now();

            DB::table('score_categories')->updateOrInsert(
                ['id' => $scoreCategory['id']],
                $scoreCategory
            );
        }
    }
}
