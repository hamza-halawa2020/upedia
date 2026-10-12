<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE student_requests MODIFY COLUMN type ENUM('complaint', 'request', 'need', 'information', 'escalation') NULL");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE student_requests MODIFY COLUMN type ENUM('complaint', 'request', 'need') NULL");

        });
    }
};
