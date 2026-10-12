<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreQuestionDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scoreQuestionDemos = [
            [
                'id' => 1,
                'question' => 'Test Quality',
            ],
            [
                'id' => 2,
                'question' => 'Tester Allocation',
            ],
            [
                'id' => 3,
                'question' => 'Tester’s Punctuality',
            ],
            [
                'id' => 4,
                'question' => 'Tester’s Communication Skills',
            ],
            [
                'id' => 5,
                'question' => 'Professionalism and Attitude',
            ],
            [
                'id' => 6,
                'question' => 'Assessment Accuracy',
            ],
            [
                'id' => 7,
                'question' => 'Handling of Student Interaction',
            ],
            [
                'id' => 8,
                'question' => 'Technical Preparedness',
            ],
            [
                'id' => 9,
                'question' => 'Error Handling',
            ],
            [
                'id' => 10,
                'question' => 'Student Feedback Discussion',
            ],
        ];

        foreach ($scoreQuestionDemos as $scoreQuestionDemo) {
            $scoreQuestionDemo['created_at'] = now();
            $scoreQuestionDemo['updated_at'] = now();

            DB::table('score_question_demos')->updateOrInsert(
                ['id' => $scoreQuestionDemo['id']],
                $scoreQuestionDemo
            );
        }
    }
}
