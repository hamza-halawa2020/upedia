<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RetestRequestTypeSeeder extends Seeder
{
    public function run(): void
    {
        $retentionDepartment = SmHumanDepartment::where('slug', 'retention')->value('id');

        $academyDepartment = SmHumanDepartment::where('slug', 'academy')->value('id');

        DB::table('hr_request_type')->insert([
            'name' => 'retest',
            'from_department_id' => $academyDepartment,
            'to_department_id' => $retentionDepartment,
            'profile_type' => 'retest',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
