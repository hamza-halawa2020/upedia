<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE exam_quiz_questions MODIFY marks DECIMAL(10, 4) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE exam_quiz_questions MODIFY marks INT UNSIGNED NULL');
    }
};
