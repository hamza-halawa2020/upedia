<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('sm_staffs', 'probation_end_date')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->date('probation_end_date')->nullable()->after('date_of_joining');
            });
        }

        DB::table('sm_staffs')
            ->select('id', 'date_of_joining')
            ->whereNotNull('date_of_joining')
            ->orderBy('id')
            ->chunkById(200, function ($staffs) {
                foreach ($staffs as $staff) {
                    DB::table('sm_staffs')
                        ->where('id', $staff->id)
                        ->update([
                            'probation_end_date' => Carbon::parse($staff->date_of_joining)
                                ->startOfDay()
                                ->addMonthsNoOverflow(3)
                                ->toDateString(),
                        ]);
                }
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('sm_staffs', 'probation_end_date')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->dropColumn('probation_end_date');
            });
        }
    }
};
