<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        foreach ($this->types() as $type) {
            $exists = DB::table('exam_question_types')
                ->where('name', $type['name'])
                ->exists();

            if ($exists) {
                DB::table('exam_question_types')
                    ->where('name', $type['name'])
                    ->update([
                        'description' => $type['description'],
                        'is_active' => true,
                        'updated_at' => $now,
                    ]);

                continue;
            }

            DB::table('exam_question_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('exam_question_types')
            ->whereIn('name', array_column($this->types(), 'name'))
            ->delete();
    }

    private function types(): array
    {
        return [
            [
                'name' => 'Listening Question',
                'description' => 'Audio-based question group with child auto-graded or manual questions.',
            ],
            [
                'name' => 'Speaking Question',
                'description' => 'Manual-graded spoken answer question.',
            ],
            [
                'name' => 'Writing Question',
                'description' => 'Manual-graded written answer question.',
            ],
            [
                'name' => 'Reading Question',
                'description' => 'Long reading passage with child auto-graded or manual questions.',
            ],
        ];
    }
};
