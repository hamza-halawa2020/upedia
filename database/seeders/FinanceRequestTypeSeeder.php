<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FinanceRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::transaction(function (){


                $retention_id = SmHumanDepartment::where('slug', 'retention')->first()->id;
                $hr_id = SmHumanDepartment::where('slug', 'hr')->first()->id;
                $marketing_id = SmHumanDepartment::where('slug', 'marketing')->first()->id;
                $finance_id = SmHumanDepartment::where('slug', 'finance')->first()->id;
                $it_id = SmHumanDepartment::where('slug', 'it')->first()->id;
                $sales_id = SmHumanDepartment::where('slug', 'sales')->first()->id;
                $schedule_id = SmHumanDepartment::where('slug', 'schedule')->first()->id;
                $admin_id = SmHumanDepartment::where('slug', 'admin')->first()->id;

                $FinanceToHr = [
                    'HR letter',
                    'Experience letter',
                    'Resignation',
                    'Salary and Bonus Collection Request',
                    'Alternative Payment Method Request',
                ];
                foreach ($FinanceToHr as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $finance_id,
                        'to_department_id' => $hr_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $FinanceToMarketing = [
                    'Design',
                ];
                foreach ($FinanceToMarketing as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $finance_id,
                        'to_department_id' => $marketing_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $FinanceToSales = [
                    'Customer Payment Follow-Up Request',
                    'Unreceived Payment Investigation Request',
                    'Customer System Upload Alert',
                    'Customer Data Error Alert',
                    'Discount Clarification Request',
                    'Payment Screenshot Update Request',
                    'Payment Method Malfunction Alert',
                ];
                foreach ($FinanceToSales as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $finance_id,
                        'to_department_id' => $sales_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $FinanceToRetention = [
                    'Customer Payment Follow-Up Request',
                    'Unreceived Payment Investigation Request',
                    'Customer System Upload Alert',
                    'Customer Data Error Alert',
                    'Discount Clarification Request',
                    'Payment Screenshot Update Request',
                    'Payment Method Malfunction Alert'
                ];
                foreach ($FinanceToRetention as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $finance_id,
                        'to_department_id' => $retention_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::table('hr_request_type')->insert([
                    'name' => 'Purchase and maintenance invoices',
                    'from_department_id' => $finance_id,
                    'to_department_id' => $it_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $FinanceToAdmin = [
                    'Summer Vacation',
                    'Annual Vacation',
                    'Repeated Case',
                    'Escalation',
                    'One-to-One Meeting',
                    'Business Need',
                ];
                foreach ($FinanceToAdmin as $type) {
                    DB::table('hr_request_type')->insert([
                        'name' => $type,
                        'from_department_id' => $finance_id,
                        'to_department_id' => $admin_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Error seeding FinanceRequestType: ' . $e->getMessage());
        }
    }
}
