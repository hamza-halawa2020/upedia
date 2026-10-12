<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('sm_staffs', 'intro_video_url')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->string('intro_video_url')->nullable()->after('staff_photo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sm_staffs', 'intro_video_url')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->dropColumn('intro_video_url');
            });
        }
    }
};
