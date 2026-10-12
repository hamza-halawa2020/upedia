<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketingRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        $marketing_id = 30;
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

                $MarketingToMarketing = [
                    'Day off',
                    'work from home',
                    'complain',
                    'postpone deadline',
                    'Performance report',
                    'Design',
                    'Video shoot',
                    'Social Media Calender',
                    'Financial Requests',
                    'Moderation Request',
                    'Warning',
                    'Deduction',
                    'Resignation',
                    'Open Request',

                ];
                foreach ($MarketingToMarketing as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $marketing_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToHr = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Pay slip Request',
                    'Escalation',
                    'Excuses',
                    'Hiring Request',
                    'Leads',
                    'Raise Request',
                    'Resignation',
                    'Deduction',
                    'Termination',
                    'Open Request',
                    'Experience certificate',
                    'Salary inquiry',
                    'Sick Leave',
                ];
                foreach ($MarketingToHr as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $hr_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToAcademic = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Instructors For shooting',
                    'Course Guide',
                    'Content Revision',
                    'Open Request',
                ];
                foreach ($MarketingToAcademic as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $academic_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToRetention = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Testimonials Request',
                    'Open Request',
                ];
                foreach ($MarketingToRetention as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $retention_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToFinance = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Price list Request',
                    'Financial Request',
                    'Offers Request',
                    'Open Request',
                ];
                foreach ($MarketingToFinance as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $finance_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToSales = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Offers Requests',
                    'Leads Feedback',
                    'Open Request',
                ];
                foreach ($MarketingToSales as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $sales_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToAdmin = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Offers Requests',
                    'Marketing Budget',
                    'Approvals',
                    'Escalation',
                    'Excuses',
                    'Raise Request',
                    'Resignation',
                    'Open Request',
                ];
                foreach ($MarketingToAdmin as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $admin_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToIt  = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Technical issues',
                    'Open Request',
                ];
                foreach ($MarketingToIt as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $it_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $MarketingToSchedule = [
                    'Complain',
                    'Postpone Shooting',
                    'Set Shooting Date ( shooting slots should open ) ',
                    'Social Media Complaints',
                    'Open Request',
                ];
                foreach ($MarketingToSchedule as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $marketing_id,
                        'to_department_id' => $schedule_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error seeding MarketingRequestType: ' . $e->getMessage());
        }
    }
}
