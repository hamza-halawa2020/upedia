<?php

namespace Database\Seeders;

use App\Models\WorkFlow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadWorkflowRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'workflow_name' => 'no answered',
                'attempt_limit' => 3,
                'notify_creator' => 1,
                'unassign_lead' => 1,
                'is_active' => 1,
            ],
            [
                'workflow_name' => 'switched off',
                'attempt_limit' => 3,
                'notify_creator' => 1,
                'unassign_lead' => 1,
                'is_active' => 1,
            ],
            [
                'workflow_name' => 'Busy',
                'attempt_limit' => 3,
                'notify_creator' => 1,
                'unassign_lead' => 1,
                'is_active' => 1,
            ],
        ];

        foreach ($rules as $rule) {
            $workflowId = WorkFlow::where('name', $rule['workflow_name'])->firstOrFail()->id;
            unset($rule['workflow_name']);

            $rule['workflow_id'] = $workflowId;
            $rule['created_at'] = now();
            $rule['updated_at'] = now();

            DB::table('lead_workflow_rules')->updateOrInsert(
                ['workflow_id' => $workflowId],
                $rule
            );
        }
    }
}
