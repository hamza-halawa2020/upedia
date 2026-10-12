<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestSlotsRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        $academyId = SmHumanDepartment::where('slug', 'academy')->value('id');
        $scheduleId = SmHumanDepartment::where('slug', 'schedule')->value('id');

        if (! $academyId || ! $scheduleId) {
            $this->command?->warn('RequestSlotsRequestTypeSeeder skipped: academy or schedule department is missing.');
            return;
        }

        foreach (['Teachers Profile', 'Testers Profile'] as $profileType) {
            DB::table('hr_request_type')->updateOrInsert(
                [
                    'name' => 'Request Slots',
                    'from_department_id' => $academyId,
                    'to_department_id' => $scheduleId,
                    'profile_type' => $profileType,
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command?->info('Seeded Request Slots request type for teachers and testers.');
    }
}
