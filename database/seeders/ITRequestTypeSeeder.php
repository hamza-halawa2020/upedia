<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ITRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::transaction(function () {

                $academic_id = SmHumanDepartment::where('slug', 'academy')->first()->id;

                $retention_id = SmHumanDepartment::where('slug', 'retention')->first()->id;
                $hr_id = SmHumanDepartment::where('slug', 'hr')->first()->id;
                $marketing_id = SmHumanDepartment::where('slug', 'marketing')->first()->id;
                $finance_id = SmHumanDepartment::where('slug', 'finance')->first()->id;
                $it_id = SmHumanDepartment::where('slug', 'it')->first()->id;
                $sales_id = SmHumanDepartment::where('slug', 'sales')->first()->id;
                $schedule_id = SmHumanDepartment::where('slug', 'schedule')->first()->id;
                $admin_id = SmHumanDepartment::where('slug', 'admin')->first()->id;

                $ItToHr = [
                    'Resignation',
                    'HR Letters',
                    'Experience Letters',
                    'Loans',
                    'Vacations',
                    'Annual Raise',
                    'Approvals',
                    'Equipment issues',
                    'Complaints',
                ];
                foreach ($ItToHr as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $it_id,
                        'to_department_id' => $hr_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::table('hr_request_type')->insert([
                    'name' => 'Revise Emails',
                    'from_department_id' => $it_id,
                    'to_department_id' => $academic_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $ItToretention_id = [
                    'Revise Emails',
                    'Tests date and time',
                ];
                foreach ($ItToretention_id as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $it_id,
                        'to_department_id' => $retention_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $ItToAdmin = [
                    'Purchase Request',
                    'Maintenance',
                    'Depreciation Request',
                    'Advice',
                    'Annual Vacation',
                ];
                foreach ($ItToAdmin as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $it_id,
                        'to_department_id' => $admin_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $ItToFinance = [
                    'Loans',
                    'Financial inquiries',
                ];
                foreach ($ItToFinance as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $it_id,
                        'to_department_id' => $finance_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error seeding ItRequestType: ' . $e->getMessage());
        }
    }
}
