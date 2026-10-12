<?php

namespace Database\Seeders;

use App\Models\HrSetting;
use Illuminate\Database\Seeder;

class HrSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HrSetting::updateOrCreate(
            ['id' => 1],
            [
                'late_minutes' => 15,
                'shift_start_at' => '10:00:00',
                'shift_end_at' => '18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
                'attendence_start_at' => '09:00:00',
                'allowed_period_to_pay_invoices' => 48,
            ],
        );
    }
}
