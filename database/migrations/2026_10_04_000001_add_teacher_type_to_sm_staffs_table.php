<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->string('teacher_type')->nullable()->after('intro_video_url');
        });
    }

    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('teacher_type');
        });
    }
};
