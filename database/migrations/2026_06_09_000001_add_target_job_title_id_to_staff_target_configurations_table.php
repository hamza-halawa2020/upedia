<?php

use App\Models\JobTitle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->foreignIdFor(JobTitle::class, 'target_job_title_id')
                ->nullable()
                ->after('job_title_id')
                ->constrained('hr_job_titles')
                ->nullOnDelete();
        });

        DB::table('staff_target_configurations')
            ->whereNull('target_job_title_id')
            ->update(['target_job_title_id' => DB::raw('job_title_id')]);
    }

    public function down(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('target_job_title_id');
        });
    }
};
