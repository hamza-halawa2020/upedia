<?php

namespace Database\Seeders;

use App\Models\ScoreCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoreSections = [
            [
                'id' => 1,
                'category_id' => 1,
                'title' => 'Classroom Management',
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'title' => 'Body Language',
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'title' => 'Involving & handling participants',
            ],
            [
                'id' => 4,
                'category_id' => 1,
                'title' => 'Material and other AV Aids',
            ],
            [
                'id' => 5,
                'category_id' => 1,
                'title' => 'Class Atmosphere',
            ],
            [
                'id' => 6,
                'category_id' => 1,
                'title' => 'Prepared for the session',
            ],
            [
                'id' => 7,
                'category_id' => 2,
                'title' => 'Following the outline stages',
            ],
            [
                'id' => 8,
                'category_id' => 2,
                'title' => 'Using the framework of ESA-approaches',
            ],
            [
                'id' => 9,
                'category_id' => 2,
                'title' => 'Checked for understanding',
            ],
            [
                'id' => 10,
                'category_id' => 2,
                'title' => 'Instructions and ICQs',
            ],
            [
                'id' => 11,
                'category_id' => 2,
                'title' => 'Used effective activities',
            ],
            [
                'id' => 12,
                'category_id' => 2,
                'title' => 'Establishing the WIFM for the session',
            ],
            [
                'id' => 13,
                'category_id' => 3,
                'title' => 'Vocabulary/word repertoire',
            ],
            [
                'id' => 14,
                'category_id' => 3,
                'title' => 'Grammar',
            ],
            [
                'id' => 15,
                'category_id' => 3,
                'title' => 'Pronunciation',
            ],
            [
                'id' => 16,
                'category_id' => 3,
                'title' => 'Intonation',
            ],
            [
                'id' => 17,
                'category_id' => 3,
                'title' => 'Fluency',
            ],
            [
                'id' => 18,
                'category_id' => 4,
                'title' => 'Interpersonal Skills',
            ],
            [
                'id' => 19,
                'category_id' => 4,
                'title' => 'Seeking and receiving feedback',
            ],
            [
                'id' => 20,
                'category_id' => 4,
                'title' => 'Commitment and Punctuality',
            ],
        ];

        foreach ($scoreSections as $scoreSection) {
            $scoreSection['category_id'] = ScoreCategory::findOrFail($scoreSection['category_id'])->id;
            $scoreSection['created_at'] = now();
            $scoreSection['updated_at'] = now();

            DB::table('score_sections')->updateOrInsert(
                ['id' => $scoreSection['id']],
                $scoreSection
            );
        }
    }
}
