<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SmHumanDepartment;

class RetentionRequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

                $RetentionToRetention = [
                    'Accent',
                    'Internet',
                    'Material',
                    'Latency',
                    'Compensate',
                    'Delay',
                    'Absence',
                    'Resignation',
                    'HomeWork',
                    'WhitBoard',
                    'Feedback',
                    'Class Management',
                    'Not Answering',
                    'Attitude',
                    '1st Feedback',
                    '2st Feedback',
                    'Exam',
                    'Grammar',
                    'Conversation',
                    'Speaking',
                    'Vocabulary',
                    'Reading',
                    'Misplaced Case',
                    'Listening',
                    'No Arabic',
                    'Requiring Arabic',
                    'PostPoning',
                    'Special Need',
                    'Converasion - Regular Feedback',
                    'Mistakes & Corrections',
                    'Motivation',
                    'Writing',
                    'Changing Time Slots',
                    'Cover',
                    'Camera Off',
                ];
                foreach ($RetentionToRetention as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $retention_id,
                        'profile_type' => 'Students Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToAcademic = [
                    'Meeting with the student',
                    'Time Slot',
                    'Repeated Case',
                    'Bad Attitude',
                    'Lack Of Communications',
                    'Resignation',
                ];
                foreach ($RetentionToAcademic as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $academic_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToSchedule = [
                    'Time Slot',
                    'Changing Time',
                    'Transfer Time',
                    'Switch Time',
                    'Close Time',
                ];
                foreach ($RetentionToSchedule as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $schedule_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToHr = [
                    'New Admin',
                    'Payslip',
                    'Deduction',
                    'Admin Fired',
                    'Advance Payment (Salary Loan)',
                    'Salary',
                ];
                foreach ($RetentionToHr as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $hr_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToSales = [
                    'Payment Details',
                    'Deal Details',
                    'Placement Test Report',
                    'Complaints: Wrong Information, Wrong Deal, Wrong Payment',
                ];
                foreach ($RetentionToSales as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $sales_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToFinance  = [
                    'Invoice',
                    'Change Payment Details',
                ];
                foreach ($RetentionToFinance as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $finance_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToMarketing = [
                    'Certificate',
                ];
                foreach ($RetentionToMarketing as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $marketing_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToRetention = [
                    'Complaint from Another Admin',
                    'Complaint from Sales',
                    'Complaint from Teacher',
                    'Complaint from Academic Admin',
                    'Complaint from Academic Supervisor',
                    'Complaint from Head of Department → CEO',
                    'Summer Vacation',
                    'Annual Vacation',
                    'Sick Leave',
                ];
                foreach ($RetentionToRetention as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $retention_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $RetentionToAdmin = [
                    'Summer Vacation',
                    'Annual Vacation',
                    'Repeated Case',
                    'Escalation',
                    'One-to-One Meeting',
                    'Business Need',
                ];
                foreach ($RetentionToAdmin as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $retention_id,
                        'to_department_id' => $admin_id,
                        'profile_type' => 'Retention Team Profile',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error seeding RetentionRequestType: ' . $e->getMessage());
        }
    }
}
