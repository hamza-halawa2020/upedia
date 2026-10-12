<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('placement_test_bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('placement_test_bookings', 'session_day_10am_reminded_at')) {
                $table->timestamp('session_day_10am_reminded_at')->nullable()->after('reminders_scheduled_at');
            }

            if (! Schema::hasColumn('placement_test_bookings', 'one_hour_before_reminded_at')) {
                $table->timestamp('one_hour_before_reminded_at')->nullable()->after('session_day_10am_reminded_at');
            }

            if (! Schema::hasColumn('placement_test_bookings', 'ten_minutes_before_reminded_at')) {
                $table->timestamp('ten_minutes_before_reminded_at')->nullable()->after('one_hour_before_reminded_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('placement_test_bookings', function (Blueprint $table) {
            foreach ([
                'ten_minutes_before_reminded_at',
                'one_hour_before_reminded_at',
                'session_day_10am_reminded_at',
            ] as $column) {
                if (Schema::hasColumn('placement_test_bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
