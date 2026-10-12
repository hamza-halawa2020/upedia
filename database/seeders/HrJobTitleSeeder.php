<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrJobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobTitles = [
            ['id' => 1, 'name' => 'academic manager', 'mail_alias' => 'academic.manager@academic.manager.com', 'department_id' => SmHumanDepartment::where('slug', 'academy')->firstOrFail()->id, 'sort' => 1, 'slug' => 'academic-manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'supervisor', 'mail_alias' => 'supervisor@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'academy')->firstOrFail()->id, 'sort' => 2, 'slug' => 'supervisor', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'academic admin', 'mail_alias' => 'acadmicadmin@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'academy')->firstOrFail()->id, 'sort' => 3, 'slug' => 'academic-admin', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'teacher', 'mail_alias' => 'teacher@upedia.test', 'department_id' => SmHumanDepartment::where('slug', 'academy')->firstOrFail()->id, 'sort' => 4, 'slug' => 'teacher', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'tester', 'mail_alias' => 'tester@tester.com', 'department_id' => SmHumanDepartment::where('slug', 'academy')->firstOrFail()->id, 'sort' => 4, 'slug' => 'tester', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Retention manager', 'mail_alias' => 'retention.manager@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'retention')->firstOrFail()->id, 'sort' => 1, 'slug' => 'retention-manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Admin', 'mail_alias' => 'Admin@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'retention')->firstOrFail()->id, 'sort' => 3, 'slug' => 'admin', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Team leader', 'mail_alias' => 'teamLeader@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'retention')->firstOrFail()->id, 'sort' => 2, 'slug' => 'team-leader', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Hr manager', 'mail_alias' => 'hrManager@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'hr')->firstOrFail()->id, 'sort' => 1, 'slug' => 'hr-manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Agent Manager', 'mail_alias' => 'AgentManager@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'sales')->firstOrFail()->id, 'sort' => 1, 'slug' => 'agent-manager', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Agent', 'mail_alias' => 'Agent@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'sales')->firstOrFail()->id, 'sort' => 2, 'slug' => 'agent', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Moderator', 'mail_alias' => 'moderator@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'marketing')->firstOrFail()->id, 'sort' => 2, 'slug' => 'moderator', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Scheduling Coordinator', 'mail_alias' => 'schedulingCordinator@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'schedule')->firstOrFail()->id, 'sort' => 1, 'slug' => 'schedule2025-09-04', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Finance Officer', 'mail_alias' => 'FinanceOfficer@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'finance')->firstOrFail()->id, 'sort' => 2, 'slug' => 'Finance Officer2025-10-07', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Finance Manager', 'mail_alias' => 'Finance@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'finance')->firstOrFail()->id, 'sort' => 1, 'slug' => 'finance-manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'IT Manager', 'mail_alias' => 'it@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'it')->firstOrFail()->id, 'sort' => 1, 'slug' => 'it-manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'HR Officer', 'mail_alias' => 'HrOfficer@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'hr')->firstOrFail()->id, 'sort' => 2, 'slug' => 'HR Officer2025-11-04', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'IT Support Specialist', 'mail_alias' => 'ITSupportSpecialist@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'it')->firstOrFail()->id, 'sort' => 2, 'slug' => 'IT Support Specialist2025-11-06', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Marketing Manager', 'mail_alias' => 'MarketingManager@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'marketing')->firstOrFail()->id, 'sort' => 1, 'slug' => 'marketing_manager', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Content creator', 'mail_alias' => 'Contentcreator@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'marketing')->firstOrFail()->id, 'sort' => 2, 'slug' => 'content_creator', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'CEO', 'mail_alias' => null, 'department_id' => SmHumanDepartment::where('slug', 'admin')->firstOrFail()->id, 'sort' => 1, 'slug' => 'CEO', 'can_delete' => 'no', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'SCHEDULE AND COMPLAINT MANAGER', 'mail_alias' => 'SCHEDULEANDCOMPLAINT@gmail.com', 'department_id' => SmHumanDepartment::where('slug', 'schedule')->firstOrFail()->id, 'sort' => 1, 'slug' => 'schedule-and-complaint-manager', 'can_delete' => 'yes', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($jobTitles as $jobTitle) {
            DB::table('hr_job_titles')->updateOrInsert(
                ['id' => $jobTitle['id']],
                $jobTitle,
            );
        }
    }
}
