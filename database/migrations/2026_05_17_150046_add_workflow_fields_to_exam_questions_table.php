<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_questions', function (Blueprint $table) {
            $table->foreignId('parent_question_id')
                ->nullable()
                ->after('id')
                ->constrained('exam_questions')
                ->nullOnDelete();
            $table->string('media_path')->nullable()->after('question');
            $table->string('media_type')->nullable()->after('media_path');
            $table->boolean('requires_manual_grading')->default(false)->after('default_time');
        });
    }

    public function down(): void
    {
        Schema::table('exam_questions', function (Blueprint $table) {
            $table->dropForeign(['parent_question_id']);
            $table->dropColumn([
                'parent_question_id',
                'media_path',
                'media_type',
                'requires_manual_grading',
            ]);
        });
    }
};
