<?php

namespace Database\Seeders;

use App\Models\CallStatus;
use Illuminate\Database\Seeder;

class CrmCallStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => 1,
                'name' => 'pending',
                'workflow_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'in_progress',
                'workflow_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'done',
                'workflow_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($statuses as $status) {
            CallStatus::updateOrCreate(
                ['id' => $status['id']],
                $status,
            );
        }
    }
}
