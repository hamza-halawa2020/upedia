<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->boolean('is_hard_copy_request_demo')
                ->default(false)
                ->after('schedule_type');
        });
    }

    public function down(): void
    {
        Schema::table('staff_scheduleds', function (Blueprint $table) {
            $table->dropColumn('is_hard_copy_request_demo');
        });
    }
};
