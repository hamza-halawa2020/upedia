<?php

namespace Database\Seeders;

use App\Models\SmHumanDepartment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmHumanDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['id' => 1, 'name' => 'Admin', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'Admin@gamil.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'admin', 'can_delete' => 'no'],
            ['id' => 2, 'name' => 'Finance', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'Finance@upedia.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'finance', 'can_delete' => 'no'],
            ['id' => 3, 'name' => 'Academy', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'academy@upedia.test', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'academy', 'can_delete' => 'no'],
            ['id' => 4, 'name' => 'Retention', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'Retention@gamil.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'retention', 'can_delete' => 'yes'],
            ['id' => 5, 'name' => 'Sales', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'Sales@gmailcom', 'parent_id' => null, 'department_head_id' => '1', 'slug' => 'sales', 'can_delete' => 'yes'],
            ['id' => 6, 'name' => 'IT', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'IT@gmail.com', 'parent_id' => null, 'department_head_id' => '1', 'slug' => 'it', 'can_delete' => 'no'],
            ['id' => 7, 'name' => 'HR', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'hr@gamil.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'hr', 'can_delete' => 'no'],
            ['id' => 8, 'name' => 'SCHEDULE AND COMPLAINT', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'schedule@gmail.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'schedule', 'can_delete' => 'no'],
            ['id' => 9, 'name' => 'complaintso old', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'complaints@complaints.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'complaints', 'can_delete' => 'no'],
            ['id' => 10, 'name' => 'marketing', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'marketing@marketing.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'marketing', 'can_delete' => 'no'],
            ['id' => 11, 'name' => 'Product', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 333, 'updated_by' => 333, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'Product@gmail.com', 'parent_id' => null, 'department_head_id' => '134', 'slug' => 'Product-2025-11-26 13:59:12', 'can_delete' => 'yes'],
            ['id' => 12, 'name' => 'test', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 333, 'updated_by' => 333, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'test@gmail.com', 'parent_id' => null, 'department_head_id' => null, 'slug' => 'test-2025-12-01 21:48:52', 'can_delete' => 'yes'],
            ['id' => 13, 'name' => 'tstsuusu', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 333, 'updated_by' => 333, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'academic@upediaworld.com', 'parent_id' => null, 'department_head_id' => '95', 'slug' => 'Academic 1-2026-04-06 15:42:34', 'can_delete' => 'yes'],
            ['id' => 14, 'name' => 'Support', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => null, 'parent_id' => null, 'department_head_id' => null, 'slug' => null, 'can_delete' => 'yes'],
            ['id' => 15, 'name' => 'tsttsts', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => null, 'parent_id' => null, 'department_head_id' => null, 'slug' => null, 'can_delete' => 'yes'],
            ['id' => 16, 'name' => 'Operations', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 1, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => null, 'parent_id' => null, 'department_head_id' => null, 'slug' => null, 'can_delete' => 'yes'],
            ['id' => 17, 'name' => 'Quality EDITED', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 1, 'updated_by' => 333, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'EFVERVERV@SFRVE.COM', 'parent_id' => null, 'department_head_id' => null, 'slug' => null, 'can_delete' => 'yes'],
            ['id' => 18, 'name' => 'Hollee Lee', 'active_status' => 1, 'created_at' => now(), 'updated_at' => now(), 'created_by' => 333, 'updated_by' => 333, 'school_id' => 1, 'is_saas' => 0, 'mail_alias' => 'jetofybeli@mailinator.com', 'parent_id' => null, 'department_head_id' => '111', 'slug' => 'Hollee Lee-2026-08-04 13:16:40', 'can_delete' => 'yes'],
        ];

        DB::transaction(function () use ($departments): void {
            foreach ($departments as $department) {
                $parentId = $department['parent_id'];
                $department['parent_id'] = null;
                $department['created_by'] = $department['created_by'] ? User::find($department['created_by'])?->id : null;
                $department['updated_by'] = $department['updated_by'] ? User::find($department['updated_by'])?->id : null;

                DB::table('sm_human_departments')->updateOrInsert(
                    ['id' => $department['id']],
                    $department,
                );

                if ($parentId !== null) {
                    DB::table('sm_human_departments')
                        ->where('id', $department['id'])
                        ->update(['parent_id' => (string) SmHumanDepartment::findOrFail($parentId)->id]);
                }
            }
        });
    }
}
