<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_workflow_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->unique()->constrained('crm_work_flows')->cascadeOnDelete();
            $table->unsignedBigInteger('attempt_limit')->default(3);
            $table->boolean('notify_creator')->default(true);
            $table->boolean('unassign_lead')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $defaultRules = [
            'no answered' => 3,
            'busy' => 3,
            'switched off' => 3,
        ];

        $rules = DB::table('crm_work_flows')
            ->get(['id', 'name'])
            ->map(function ($workflow) use ($defaultRules) {
                $name = strtolower(trim(str_replace('_', ' ', $workflow->name)));

                if (! array_key_exists($name, $defaultRules)) {
                    return null;
                }

                return [
                    'workflow_id' => $workflow->id,
                    'attempt_limit' => $defaultRules[$name],
                    'notify_creator' => true,
                    'unassign_lead' => true,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->filter()
            ->values()
            ->all();

        if ($rules) {
            DB::table('lead_workflow_rules')->insert($rules);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_workflow_rules');
    }
};
