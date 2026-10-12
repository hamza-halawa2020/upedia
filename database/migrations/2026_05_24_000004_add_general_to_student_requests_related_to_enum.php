<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('student_requests', 'related_to') && DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE student_requests MODIFY related_to ENUM('activities','homework','whiteboard','curriculum','time','general') NULL");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('student_requests', 'related_to') && DB::getDriverName() === 'mysql') {
            DB::table('student_requests')->where('related_to', 'general')->update(['related_to' => null]);
            DB::statement("ALTER TABLE student_requests MODIFY related_to ENUM('activities','homework','whiteboard','curriculum','time') NULL");
        }
    }
};
