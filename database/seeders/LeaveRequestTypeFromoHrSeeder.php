<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestTypeFromoHrSeeder extends Seeder
{
    public function run(): void
    {
        $hrDepartment = SmHumanDepartment::where('slug', 'hr')->value('id');

        $departments = SmHumanDepartment::where('slug','!=', 'hr')->select('id', 'name')->get();

        foreach ($departments as $dept) {
            DB::table('hr_request_type')->insert([
                'name' => 'Leave',
                'from_department_id' => $hrDepartment,
                'to_department_id' =>  $dept->id,
                'profile_type' => 'Employees Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
