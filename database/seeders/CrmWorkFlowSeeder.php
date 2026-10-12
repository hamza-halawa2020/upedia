<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmWorkFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workFlows = [
            ['id' => 33, 'name' => 'Answered-old', 'sort' => 2, 'type' => 'lead', 'action_type' => null, 'children' => '["39","38"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'no answered', 'sort' => 3, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => '["71","70","69","43","39","36","35","34"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'wrong number', 'sort' => 4, 'type' => 'lead', 'action_type' => null, 'children' => '["55"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'switched off', 'sort' => 5, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => '["33"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Wrong Number-old', 'sort' => 6, 'type' => 'lead', 'action_type' => null, 'children' => '["55"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'interested-old', 'sort' => 7, 'type' => 'lead', 'action_type' => null, 'children' => '["45","44","43","42","41","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'not interested', 'sort' => 8, 'type' => 'lead', 'action_type' => 'not_interested_reasons', 'children' => '["55"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'on spot payment', 'sort' => 9, 'type' => 'lead', 'action_type' => null, 'children' => '["46","43","42","41"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'test', 'sort' => 10, 'type' => 'lead', 'action_type' => null, 'children' => '["47","46","45","43","42","40","34"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'demo', 'sort' => 11, 'type' => 'lead', 'action_type' => null, 'children' => '["47","46","45","43","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'paid', 'sort' => 12, 'type' => 'lead', 'action_type' => null, 'children' => '["41"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'reschedule', 'sort' => 13, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'negotiation', 'sort' => 14, 'type' => 'lead', 'action_type' => 'not_interested_reasons', 'children' => '["46","43","42","41","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'close lost', 'sort' => 15, 'type' => 'lead', 'action_type' => null, 'children' => '["54","53","50","49"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'reschedule test', 'sort' => 16, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'paid deposit', 'sort' => 17, 'type' => 'lead', 'action_type' => null, 'children' => '["42","41"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 51, 'name' => 'paid test', 'sort' => 20, 'type' => 'lead', 'action_type' => null, 'children' => '["46","42","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'name' => 'paid demo', 'sort' => 21, 'type' => 'lead', 'action_type' => null, 'children' => '["46","41","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 55, 'name' => 'New', 'sort' => 1, 'type' => 'lead', 'action_type' => null, 'children' => '["74","73","72","71","70","69","43","42","39","36","35","34"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 65, 'name' => 'Schedule', 'sort' => 20, 'type' => 'lead', 'action_type' => null, 'children' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 69, 'name' => 'potential', 'sort' => 7, 'type' => 'lead', 'action_type' => null, 'children' => '["45","43","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 70, 'name' => 'high potential', 'sort' => 7, 'type' => 'lead', 'action_type' => null, 'children' => '["45","43","40"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 71, 'name' => 'Busy', 'sort' => 3, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => '["71","70","69","43","39","36","35","34"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 72, 'name' => 'pending', 'sort' => 3, 'type' => 'lead', 'action_type' => 'reschedule_call', 'children' => '["71","70","69","43","40","39","36","34"]', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 73, 'name' => 'student', 'sort' => 4, 'type' => 'lead', 'action_type' => null, 'children' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 74, 'name' => 'job', 'sort' => 4, 'type' => 'lead', 'action_type' => null, 'children' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($workFlows as $workFlow) {
            DB::table('crm_work_flows')->updateOrInsert(
                ['id' => $workFlow['id']],
                $workFlow,
            );
        }
    }
}
