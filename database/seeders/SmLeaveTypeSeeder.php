<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SmLeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'id' => 1,
                'type' => 'Casual Leave',
                'total_days' => 5,
                'active_status' => 1,
                'max_leaves_allowed' => null,
                'applicable_after_work_days' => null,
                'is_leave_without_pay' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
                'academic_id' => 1,
            ],
            [
                'id' => 2,
                'type' => 'Sick Leave',
                'total_days' => 9,
                'active_status' => 1,
                'max_leaves_allowed' => null,
                'applicable_after_work_days' => null,
                'is_leave_without_pay' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
                'academic_id' => 1,
            ],
            [
                'id' => 4,
                'type' => 'Annual Leave',
                'total_days' => 21,
                'active_status' => 1,
                'max_leaves_allowed' => 15,
                'applicable_after_work_days' => 90,
                'is_leave_without_pay' => 0,
                'created_by' => 333,
                'updated_by' => 1,
                'school_id' => 1,
                'academic_id' => 1,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            $leaveType['created_by'] = $this->optionalUserId($leaveType['created_by']) ?? 1;
            $leaveType['updated_by'] = $this->optionalUserId($leaveType['updated_by']) ?? 1;
            $leaveType['created_at'] = now();
            $leaveType['updated_at'] = now();

            if (! Schema::hasColumn('sm_leave_types', 'school_id')) {
                unset($leaveType['school_id']);
            }

            if (! Schema::hasColumn('sm_leave_types', 'academic_id')) {
                unset($leaveType['academic_id']);
            }

            DB::table('sm_leave_types')->updateOrInsert(
                ['id' => $leaveType['id']],
                $leaveType
            );
        }
    }

    private function optionalUserId(?int $userId): ?int
    {
        return $userId ? User::find($userId)?->id : null;
    }
}
