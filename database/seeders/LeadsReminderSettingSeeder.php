<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsReminderSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leads_reminder_settings')->updateOrInsert(
            ['id' => 1],
            [
                'max_reminders' => 3,
                'interval_hours' => 2,
                'delay_hours' => null,
                'action' => '"[\"send_email\",\"Unassign\"]"',
                'workflow_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}
