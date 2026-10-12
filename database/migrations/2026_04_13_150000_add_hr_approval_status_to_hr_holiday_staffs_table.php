<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('hr_holiday_staffs', 'hr_approval_status')) {
            Schema::table('hr_holiday_staffs', function (Blueprint $table) {
                $table->enum('hr_approval_status', ['pending', 'approved', 'rejected'])
                    ->default('pending')
                    ->after('type');
            });
        }

        DB::table('hr_holiday_staffs')
            ->select('id', 'hr_request_id')
            ->orderBy('id')
            ->chunkById(200, function ($records) {
                $requestStatuses = DB::table('hr_requests')
                    ->whereIn('id', $records->pluck('hr_request_id')->filter()->unique()->values())
                    ->pluck('status', 'id');

                foreach ($records as $record) {
                    $requestStatus = $requestStatuses[$record->hr_request_id] ?? null;
                    $approvalStatus = match ($requestStatus) {
                        'done' => 'approved',
                        'rejected' => 'rejected',
                        default => 'pending',
                    };

                    DB::table('hr_holiday_staffs')
                        ->where('id', $record->id)
                        ->update(['hr_approval_status' => $approvalStatus]);
                }
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('hr_holiday_staffs', 'hr_approval_status')) {
            Schema::table('hr_holiday_staffs', function (Blueprint $table) {
                $table->dropColumn('hr_approval_status');
            });
        }
    }
};
