<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SmHumanDepartment;

class HrRequestTypeSeeder extends Seeder
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
                $HrToAcademic = [
                    'Requesting induction',
                    'Requesting training',
                    'Teacher cases',
                    'Demos date and time',
                ];
                foreach ($HrToAcademic as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $academic_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToIT = [
                    'new laptop',
                    'make fingerprint',
                    'changes to system access',
                    'new Emails',
                    'Technical issues',
                ];
                foreach ($HrToIT as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $it_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToFinance = [
                    'new sim cards',
                    'payroll updates',
                    'financial request',
                ];
                foreach ($HrToFinance as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $finance_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToSales = [
                    'employee commission plan',
                    '(KPIs)',
                ];
                foreach ($HrToSales as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $sales_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToMarketing = [
                    'Marketing',
                    'designs',
                    'Ads',
                ];
                foreach ($HrToMarketing as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $marketing_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToRetention = [
                    'Teacher’s working hours'
                ];
                foreach ($HrToRetention as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $retention_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToScheduling = [
                    'More slots to teachers',
                    'Teacher’s needs',
                ];
                foreach ($HrToScheduling as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $schedule_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToHr = [
                    'Teacher’s needs',
                    'Business meetings',
                    'Day off',
                    'Complains',
                    'Annual raise',
                    'Financial requests',
                    'To do lists',
                    'Demos inquires',
                ];
                foreach ($HrToHr as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $hr_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $HrToAdmin = [
                    'Approvals',
                    'Escalation',
                    'Annual raise request',
                    'Resignations',
                    'Excuses',
                    'Inquires',
                ];
                foreach ($HrToAdmin as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $hr_id,
                        'to_department_id' => $admin_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error seeding HrRequestType: ' . $e->getMessage());
        }
    }
}
