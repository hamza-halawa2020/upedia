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
            $table->enum('submission_status', ['on_time', 'late'])->default('on_time')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_feedback', function (Blueprint $table) {
            $table->dropColumn('submission_status');
        });
    }
};
