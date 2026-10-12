<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItRequestTicketToItSeeder extends Seeder
{
    public function run(): void
    {
        $hrDepartment = SmHumanDepartment::where('slug', 'it')->value('id');

        $departments = SmHumanDepartment::select('id', 'name')->get();

        foreach ($departments as $dept) {
            DB::table('hr_request_type')->insert([
                'name' => 'it-ticket',
                'from_department_id' => $dept->id,
                'to_department_id' => $hrDepartment,
                'profile_type' => 'Employees Profile',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
