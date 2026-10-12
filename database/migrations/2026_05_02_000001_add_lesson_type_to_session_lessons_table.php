<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('session_lessons', function (Blueprint $table) {
            $table->enum('lesson_type', ['session_material', 'lesson_plan'])
                ->default('session_material')
                ->after('session_id');
        });
    }

    public function down(): void
    {
        Schema::table('session_lessons', function (Blueprint $table) {
            $table->dropColumn('lesson_type');
        });
    }
};
