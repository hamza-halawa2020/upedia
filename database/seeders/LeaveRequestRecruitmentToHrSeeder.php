<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestRecruitmentToHrSeeder extends Seeder
{
    public function run(): void
    {
        $hrDepartment = SmHumanDepartment::where('slug', 'hr')->value('id');

        $departments = SmHumanDepartment::select('id', 'name')->get();

        foreach ($departments as $dept) {
            DB::table('hr_request_type')->insert([
                'name' => 'Recruitment',
                'from_department_id' => $dept->id,
                'to_department_id' => $hrDepartment,
                'profile_type' => 'Employees Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
