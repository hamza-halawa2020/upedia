<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hr_job_titles', function (Blueprint $table) {
            $table->integer('sort')->after('department_id')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('hr_job_titles', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
};
