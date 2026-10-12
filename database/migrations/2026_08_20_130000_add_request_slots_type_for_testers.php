<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $academyId = DB::table('sm_human_departments')->where('slug', 'academy')->value('id');
        $scheduleId = DB::table('sm_human_departments')->where('slug', 'schedule')->value('id');

        if (! $academyId || ! $scheduleId) {
            return;
        }

        $attributes = [
            'name' => 'Request Slots',
            'from_department_id' => $academyId,
            'to_department_id' => $scheduleId,
            'profile_type' => 'Testers Profile',
        ];

        if (DB::table('hr_request_type')->where($attributes)->exists()) {
            DB::table('hr_request_type')->where($attributes)->update(['updated_at' => now()]);
            return;
        }

        DB::table('hr_request_type')->insert($attributes + [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        $academyId = DB::table('sm_human_departments')->where('slug', 'academy')->value('id');
        $scheduleId = DB::table('sm_human_departments')->where('slug', 'schedule')->value('id');

        if (! $academyId || ! $scheduleId) {
            return;
        }

        DB::table('hr_request_type')
            ->where('name', 'Request Slots')
            ->where('from_department_id', $academyId)
            ->where('to_department_id', $scheduleId)
            ->where('profile_type', 'Testers Profile')
            ->delete();
    }
};
