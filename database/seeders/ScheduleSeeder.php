<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmHumanDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::transaction(function () {
                $academic_id = SmHumanDepartment::where('slug', 'academy')->first()->id;
                $retention_id = SmHumanDepartment::where('slug', 'retention')->first()->id;
                $finance_id = SmHumanDepartment::where('slug', 'finance')->first()->id;
                $sales_id = SmHumanDepartment::where('slug', 'sales')->first()->id;
                $schedule_id = SmHumanDepartment::where('slug', 'schedule')->first()->id;
                $admin_id = SmHumanDepartment::where('slug', 'admin')->first()->id;
                DB::table('hr_request_type')->insert([
                    'name' => "Rescheduling Group",
                    'from_department_id' => $schedule_id,
                    'to_department_id' => $admin_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('hr_request_type')->insert([
                    'name' => "New Instructors",
                    'from_department_id' => $schedule_id,
                    'to_department_id' => $admin_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $ScheduleToAcademic = [
                    "Update Academic Note",
                    "Cover Session",
                    "Practice Session",
                    "Exception",
                    "Schedule Placement Test",
                ];
                foreach ($ScheduleToAcademic as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $schedule_id,
                        'to_department_id' => $academic_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $ScheduleToFinance = [
                    "Missing Data",
                    "Review Client",
                    "Update",
                ];
                foreach ($ScheduleToFinance as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $schedule_id,
                        'to_department_id' => $finance_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::table('hr_request_type')->insert([
                    'name' => "Request To New Sales",
                    'from_department_id' => $schedule_id,
                    'to_department_id' => $sales_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('hr_request_type')->insert([
                    'name' => "Request To New Sales",
                    'from_department_id' => $schedule_id,
                    'to_department_id' => $retention_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error seeding HrRequestType: ' . $e->getMessage());
        }
    }
}
