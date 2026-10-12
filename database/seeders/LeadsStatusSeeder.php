<?php

namespace Database\Seeders;

use App\Models\LeadsStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'not_contacted', 'parent_id' => null, 'is_default' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'answer', 'parent_id' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'interested', 'parent_id' => 2, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'reschedule', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'follow_up_payment', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'test', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'demo', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'paid', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'negotiation', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'no_answer', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'close_lost', 'parent_id' => 4, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'follow_up_payment', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'follow_up_payment', 'parent_id' => 12, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'follow_up_payment', 'parent_id' => 12, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'follow_up_payment', 'parent_id' => 12, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'follow_up_payment', 'parent_id' => 12, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'test', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'test', 'parent_id' => 17, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'demo', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'demo', 'parent_id' => 24, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'paid', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'paid', 'parent_id' => 31, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'negotiation', 'parent_id' => 3, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'follow_up_payment', 'parent_id' => 33, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'test', 'parent_id' => 33, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'demo', 'parent_id' => 33, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'paid', 'parent_id' => 33, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'negotiation', 'parent_id' => 33, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'not_interested', 'parent_id' => 2, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'no_answer', 'parent_id' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'answer', 'parent_id' => 40, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'no_answer', 'parent_id' => 40, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'wrong_number', 'parent_id' => 40, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'switched_off', 'parent_id' => 40, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'invalid_number', 'parent_id' => 40, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'wrong_number', 'parent_id' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'switched_off', 'parent_id' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'invalid_number', 'parent_id' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::transaction(function () use ($statuses): void {
            foreach ($statuses as $status) {
                $parentId = $status['parent_id'];
                $status['parent_id'] = null;

                DB::table('crm_leads_statuses')->updateOrInsert(
                    ['id' => $status['id']],
                    $status,
                );

                if ($parentId !== null) {
                    DB::table('crm_leads_statuses')
                        ->where('id', $status['id'])
                        ->update(['parent_id' => LeadsStatus::findOrFail($parentId)->id]);
                }
            }
        });
    }
}
