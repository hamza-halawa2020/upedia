<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_quiz_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('marks')->nullable()->after('question_id');
        });
    }

    public function down(): void
    {
        Schema::table('exam_quiz_questions', function (Blueprint $table) {
            $table->dropColumn('marks');
        });
    }
};
