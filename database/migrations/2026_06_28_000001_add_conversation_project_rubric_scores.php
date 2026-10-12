<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversation_project_submissions', function (Blueprint $table) {
            $table->decimal('pronunciation_intonation_score', 5, 2)->nullable()->after('uploaded_file_path');
            $table->decimal('vocabulary_lexical_range_score', 5, 2)->nullable()->after('pronunciation_intonation_score');
            $table->decimal('fluency_cohesion_score', 5, 2)->nullable()->after('vocabulary_lexical_range_score');
            $table->decimal('grammar_syntax_score', 5, 2)->nullable()->after('fluency_cohesion_score');
            $table->decimal('communication_strategies_score', 5, 2)->nullable()->after('grammar_syntax_score');
        });
    }

    public function down(): void
    {
        Schema::table('conversation_project_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'pronunciation_intonation_score',
                'vocabulary_lexical_range_score',
                'fluency_cohesion_score',
                'grammar_syntax_score',
                'communication_strategies_score',
            ]);
        });
    }
};
