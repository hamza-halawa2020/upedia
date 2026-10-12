<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;

class CrmReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            ['id' => 1, 'reason' => 'short of money', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'reason' => 'language barriers', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'reason' => 'click by mistake', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'reason' => 'too expensive', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'reason' => 'competitive offer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'reason' => 'offline', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'reason' => 'other', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($reasons as $reason) {
            Reason::updateOrCreate(
                ['id' => $reason['id']],
                $reason,
            );
        }
    }
}
