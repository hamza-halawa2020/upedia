<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrRequestTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hr_request_type')->truncate();
        DB::table('hr_requests')->truncate();
        DB::table('replies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call([
            AcademicRequestTypeSeeder::class,
            FinanceRequestTypeSeeder::class,
            HrRequestTypeSeeder::class,
            ITRequestTypeSeeder::class,
            MarketingRequestTypeSeeder::class,
            RetentionRequestTypeSeeder::class,
            SalesRequestTypeSeeder::class,
            ScheduleSeeder::class,
            LeaveRequestRecruitmentToHrSeeder::class,
            LeaveRequestTypeFromoHrSeeder::class,
            LeaveRequestTypeSelfSeeder::class,
            ItRequestTicketToItSeeder::class,
            RetestRequestTypeSeeder::class,
            RequestSlotsRequestTypeSeeder::class,

        ]);
        $hrDepartmentId = SmHumanDepartment::where('slug', 'hr')->firstOrFail()->id;

        DB::table('hr_request_type')->insert([
            'name' => 'Holiday Automatic Request',
            'from_department_id' => $hrDepartmentId,
            'to_department_id' => $hrDepartmentId,
            'profile_type' => 'Holiday Automatic Request',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

}
