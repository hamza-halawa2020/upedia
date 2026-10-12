<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('hr_holiday_staffs', 'hr_rejection_reason')) {
            Schema::table('hr_holiday_staffs', function (Blueprint $table) {
                $table->string('hr_rejection_reason')->nullable()->after('hr_approval_status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('hr_holiday_staffs', 'hr_rejection_reason')) {
            Schema::table('hr_holiday_staffs', function (Blueprint $table) {
                $table->dropColumn('hr_rejection_reason');
            });
        }
    }
};
