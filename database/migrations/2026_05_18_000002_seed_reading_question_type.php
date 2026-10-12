<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('exam_question_types')->updateOrInsert(
            ['name' => 'Reading Question'],
            [
                'description' => 'Long reading passage with child auto-graded or manual questions.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('exam_question_types')
            ->where('name', 'Reading Question')
            ->delete();
    }
};
