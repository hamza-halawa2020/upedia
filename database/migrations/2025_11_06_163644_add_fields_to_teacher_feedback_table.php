<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teacher_feedback', function (Blueprint $table) {
            $table->string('suggested_levels')->nullable();
            $table->string('suggested_band')->nullable();
    
            $table->text('demo_listening')->nullable();
            $table->text('demo_reading')->nullable();
            $table->text('demo_speaking')->nullable();
            $table->text('demo_vocabulary')->nullable();
            $table->text('demo_grammar')->nullable();
    
            $table->text('objectivies')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('teacher_feedback', function (Blueprint $table) {
            $table->dropColumn([
                'suggested_levels',
                'suggested_band',
                'demo_listening',
                'demo_reading',
                'demo_speaking',
                'demo_vocabulary',
                'demo_grammar',
                'objectivies',
            ]);
        });
    }
};
