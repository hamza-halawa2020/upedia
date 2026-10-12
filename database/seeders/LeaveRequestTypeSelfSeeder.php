<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestTypeSelfSeeder extends Seeder
{
    public function run(): void
    {
        $departments = SmHumanDepartment::select('id', 'name')->get();

        foreach ($departments as $dept) {
            DB::table('hr_request_type')->insert([
                'name' => 'Leave',
                'from_department_id' => $dept->id,
                'to_department_id' => $dept->id,
                'profile_type' => 'Employees Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $retentionDepartmentId = SmHumanDepartment::where('slug', 'retention')->firstOrFail()->id;
        $hrDepartmentId = SmHumanDepartment::where('slug', 'hr')->firstOrFail()->id;

        DB::table('hr_request_type')->insert([
            'name' => 'Leave',
            'from_department_id' => $retentionDepartmentId,
            'to_department_id' => $hrDepartmentId,
            'profile_type' => 'Employees Profile',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
