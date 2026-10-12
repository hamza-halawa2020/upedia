<?php

use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_target_configuration_groups', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignIdFor(User::class, 'created_by')->constrained('users');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('sm_human_departments')->nullOnDelete();
            $table->foreignIdFor(JobTitle::class, 'job_title_id')->constrained('hr_job_titles');
            $table->enum('target_type', ['number', 'percentage']);
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });

        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->foreignId('group_id')
                ->nullable()
                ->after('id')
                ->constrained('staff_target_configuration_groups')
                ->nullOnDelete();
        });

        DB::table('staff_target_configurations')
            ->orderBy('id')
            ->get()
            ->each(function ($configuration) {
                $groupId = DB::table('staff_target_configuration_groups')->insertGetId([
                    'type' => $configuration->type,
                    'created_by' => $configuration->created_by,
                    'department_id' => $configuration->department_id,
                    'job_title_id' => $configuration->job_title_id,
                    'target_type' => $configuration->target_type,
                    'percentage' => $configuration->percentage,
                    'created_at' => $configuration->created_at,
                    'updated_at' => $configuration->updated_at,
                ]);

                DB::table('staff_target_configurations')
                    ->where('id', $configuration->id)
                    ->update(['group_id' => $groupId]);
            });
    }

    public function down(): void
    {
        Schema::table('staff_target_configurations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('group_id');
        });

        Schema::dropIfExists('staff_target_configuration_groups');
    }
};
