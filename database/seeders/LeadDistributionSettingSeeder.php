<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadDistributionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'id' => 1,
                'distribution_method' => 'manual',
                'morning_shift_capacity' => null,
                'evening_shift_capacity' => null,
                'created_by' => 298,
                'updated_by' => 291,
            ],
        ];

        foreach ($settings as $setting) {
            $setting['created_by'] = $this->optionalStaffId($setting['created_by']);
            $setting['updated_by'] = $this->optionalStaffId($setting['updated_by']);
            $setting['created_at'] = now();
            $setting['updated_at'] = now();

            DB::table('lead_distribution_settings')->updateOrInsert(
                ['id' => $setting['id']],
                $setting
            );
        }
    }

    private function optionalStaffId(?int $staffId): ?int
    {
        return $staffId ? Staff::withoutGlobalScopes()->find($staffId)?->id : null;
    }
}
