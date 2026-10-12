<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesRequestTypeSeeder extends Seeder
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

            $SalesToSales = [
                'Day off',
                'Work from home',
                'Complain',
                'Financial requests',
                'Warning',
                'Deduction',
                'Resignation',
                'Refund',
                'Deposit',
                'Discount',
                'Special offer',
                'Follow up',
                'Leads',
                'Excuses',
                'Target',
                'Daily target',
                'New class',
                'Free trial',
                'Expception',
                'Deadline',
                'announcement',
                'Placementest',
                'Delay tester',
                'Feedback',
                'Test',
                'Issue',
                'Special need',

            ];
            foreach ($SalesToSales as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $sales_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $SalesToHr = [
                'Complain',
                'Pay slip',
                'Escalation',
                'Excuses',
                'Hiring request',
                'Raise request',
                'Resignation',
                'Deduction',
                'Termination',
                'Over time',
                
        
            ];
            foreach ($SalesToHr as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $hr_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }            


             $SalesToAcademic = [
                'Complain',
                'Course guide',
                'Test slot',
                'Repeated case',
                'Bad attitude',
                'Lack of communication',
                'question',
                
            ];
            foreach ($SalesToAcademic as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $academic_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $SalesToRetention = [
                'Changing admins',
                'Changing time',
                'Repeated case',
                'Bad attitude',
                'Lack of communication',
                'question',
                'issue',
                'need',
                'student confirmation',
                'mistake',
                'edit',
                'gift call',
                'special case',
                'request',
            ];
            foreach ($SalesToRetention as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $retention_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $SalesToMarketing = [
                'shooting video inquiry',
                'designes',
                'question',
                'request',
            ];
            foreach ($SalesToMarketing as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $marketing_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $SalesToSchedule = [
                'Time Slot',
                'Changing Time',
                'Transfer Time',
                'Switch Time',
                'Close Time',
                'New batch',
                'Urgent',
                'Need',
                'Request',
            ];
            foreach ($SalesToSchedule as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $schedule_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $SalesToFinance = [
                'Invoice',
                'Change payment details',
                'Confirm the process',
                'Faild',
                'Request',
                'question',
            ];
            foreach ($SalesToFinance as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $finance_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $SalesToAdmin = [
                'Vacation',
                'Annual Vacation',
                'Repeated Case',
                'Escalation',
                'One-to-One Meeting',
                'Business Need',
            ];
            foreach ($SalesToAdmin as $type) {
                DB::table('hr_request_type')->insert([
                    'name' => $type,
                    'from_department_id' => $sales_id,
                    'to_department_id' => $admin_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('hr_request_type')->insert([
                'name' => 'inquiry',
                'from_department_id' => $sales_id,
                'to_department_id' => $it_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
