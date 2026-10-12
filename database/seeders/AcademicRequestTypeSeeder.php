<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
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

            $AcademicToRetention = [
                'Feedback report',
                'Arranging a meeting with Student',
                'Sessions links',
                'Working hours confirmation',
                'Following up with cases',
                'Recorded sessions',
                'Changing academic note',
                'Announcement',
            ];
            foreach ($AcademicToRetention as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $retention_id,
                    'profile_type' => 'Supervisors Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToHR = [
                'Experience letter',
                'Pay slip',
                'Deduction inquiry',
                'Resignation',
                'Investigation',
                'Escalation',
                'Increasing working hours',
                'Salary’s calculation',
                'Demos',
                'Recommendations',
                'HR letter',
                'Checking paid/unpaid annuals',
                'Announcement',
            ];
            foreach ($AcademicToHR as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $hr_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToMarketing = [
                'Changing shooting days',
                'Certificates templates',
                'PPT templates',
                'Suggestions',
                'Announcement',
            ];
            foreach ($AcademicToMarketing as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $marketing_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToFinance = [
                'Paying for external organization',
                'Inquiry',
                'Salary’s inquiry',
                'Announcement',
            ];
            foreach ($AcademicToFinance as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $finance_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToIT = [
                'Internet issues',
                'Updating the domain list',
                'Groups’ tests issues',
                'Passwords',
                'Creating email to a newcomer',
                'Functions',
            ];
            foreach ($AcademicToIT as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $it_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToSales = [
                'Performance reports',
                'Tests numbers',
                'Recorded tests',
                'Escalating',
            ];
            foreach ($AcademicToSales as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $sales_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToSchedule = [
                'Opening slots',
                'Closing slots',
                'Stop assigning classes',
                'Inquiry of dash board',
            ];
            foreach ($AcademicToSchedule as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $schedule_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToAcademic = [
                'Vacation',
                'Resignation',
                'Meeting',
                'Demo /proposal',
                'Escalating',
                'Developing program',
                'Waiting for approval',
                'Announcement',
            ];
            foreach ($AcademicToAcademic as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $academic_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToAdmin = [
                'Vacation',
                'Resignation',
                'Escalating',
                'Developing program',
                'Waiting for approval',
                'Meeting',
            ];
            foreach ($AcademicToAdmin as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $admin_id,
                    'profile_type' => 'Supervisors Profile',

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }


            // Teachers Profile
            $AcademicToRetention = [
                'Changing admins',
                'Sending extra materials to the students',
            ];
            foreach ($AcademicToRetention as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $retention_id,
                    'profile_type' => 'Teachers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToHr = [
                'Experience certificate',
                'Pay slip',
                'Salary inquiry',
                'Salary raise',
                'Deduction inquiry',
                'Recommendation',
                'Changing payment method',
            ];
            foreach ($AcademicToHr as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $hr_id,
                    'profile_type' => 'Teachers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('hr_request_type')->insert([
                'name' => 'Shooting video inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $marketing_id,
                'profile_type' => 'Teachers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $AcademicToFinance = [
                'Changing payment method',
                'Inquiry',
            ];
            foreach ($AcademicToFinance as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $finance_id,
                    'profile_type' => 'Teachers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => 'Inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $it_id,
                'profile_type' => 'Teachers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('hr_request_type')->insert([
                'name' => 'Inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $sales_id,
                'profile_type' => 'Teachers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $AcademicToSchedule = [
                'Opening new slots',
                'Closing slots',
                'Changing shifts',
                'Checking dashboard data',
                'Request Slots',
            ];
            foreach ($AcademicToSchedule as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $schedule_id,
                    'profile_type' => 'Teachers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicToAcademic = [
                'Vacation',
                'Misplaced students',
                'Resignation',
                'Escalating',
                'Developing program',
                'Waiting for approval',
            ];
            foreach ($AcademicToAcademic as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $academic_id,
                    'profile_type' => 'Teachers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => 'Escalation',
                'from_department_id' => $academic_id,
                'to_department_id' => $admin_id,
                'profile_type' => 'Teachers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Testers Profile
            DB::table('hr_request_type')->insert([
                'name' => 'Inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $retention_id,
                'profile_type' => 'Testers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $AcademicHr = [
                'Experience certificate',
                'Pay slip',
                'Salary inquiry',
                'Salary raise',
                'Deduction inquiry',
                'Recommendation',
                'Changing payment method',
            ];
            foreach ($AcademicHr as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $hr_id,
                    'profile_type' => 'Testers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => 'Inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $marketing_id,
                'profile_type' => 'Testers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $AcademicFinance = [
                'Changing payment method',
                'Inquiry',
            ];
            foreach ($AcademicFinance as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $finance_id,
                    'profile_type' => 'Testers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => 'Inquiry',
                'from_department_id' => $academic_id,
                'to_department_id' => $it_id,
                'profile_type' => 'Testers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $AcademicSales = [
                'sending performance report',
                'checking student’s data',
                'inquiry',
            ];
            foreach ($AcademicSales as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $sales_id,
                    'profile_type' => 'Testers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $AcademicSchedule = [
                'Opening new slots',
                'Closing slots',
                'Changing shifts',
                'Checking dashboard data',
                'Request Slots',
            ];
            foreach ($AcademicSchedule as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $schedule_id,
                    'profile_type' => 'Testers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $AcademicAcademic = [
                'Vacation',
                'Resignation',
                'Escalating',
                'Developing program',
                'Waiting for approval',
            ];

            foreach ($AcademicAcademic as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $academic_id,
                    'to_department_id' => $academic_id,
                    'profile_type' => 'Testers Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => "Escalation",
                'from_department_id' => $academic_id,
                'to_department_id' => $admin_id,
                'profile_type' => 'Testers Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
