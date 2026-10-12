<?php

namespace Database\Seeders;

use App\Models\WorkFlow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmLeadActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leadActions = [
            ['id' => 22, 'action' => 'payment', 'workflow_id' => WorkFlow::findOrFail(43)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'action' => 'call', 'workflow_id' => WorkFlow::findOrFail(55)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'action' => 'test', 'workflow_id' => WorkFlow::findOrFail(47)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'action' => 'task', 'workflow_id' => WorkFlow::findOrFail(55)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'action' => 'demo', 'workflow_id' => WorkFlow::findOrFail(42)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'action' => 'product', 'workflow_id' => WorkFlow::findOrFail(44)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'action' => 'reschedule', 'workflow_id' => WorkFlow::findOrFail(52)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'action' => 'invoice', 'workflow_id' => WorkFlow::findOrFail(40)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'action' => 'schedule', 'workflow_id' => WorkFlow::findOrFail(65)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'action' => 'deal', 'workflow_id' => WorkFlow::findOrFail(55)->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'action' => 'paid deposite', 'workflow_id' => WorkFlow::findOrFail(48)->id, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($leadActions as $leadAction) {
            DB::table('crm_leadactions')->updateOrInsert(
                ['id' => $leadAction['id']],
                $leadAction,
            );
        }
    }
}
