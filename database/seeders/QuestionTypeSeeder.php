<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionTypes = [
            'Multiple Choice Single Answer Question',
            'Multiple Choice Multiple Answers Question',
            'True or False Question',
            'Short Answer Question',
            'Match the Following Question',
            'Ordering/Sequence Question',
            'Fill in the Blanks Question',
        ];

        foreach ($questionTypes as $questionType) {
            QuestionType::updateOrCreate(
                ['name' => $questionType],
                [
                    'icon_path' => null,
                    'description' => null,
                    'is_active' => true,
                ],
            );
        }
    }
}
