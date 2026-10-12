<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_exams', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'created_by')->nullable()->after('track_level_id');
        });
    }

    public function down(): void
    {
        Schema::table('exam_exams', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};
