<?php

namespace App\Listeners;

use App\Events\AttendanceLoggerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceLogListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AttendanceLoggerEvent $event): void
    {


        $data = [
            'check_in' => now()->format('H:i'),
            'attendence_date' => now()->format('Y-m-d'),
            'staff_id' => $event->user->staff->id,

        ];
        $now = now();


        $settings = DB::table('hr_settings')->first();

        if ($settings) {
            $start = Carbon::parse($settings->attendence_start_at);
            if (!$now->greaterThanOrEqualTo($start)) {
                return;
            }

            DB::table('sm_staff_attendences')->insert($data);

        }

    }
}
