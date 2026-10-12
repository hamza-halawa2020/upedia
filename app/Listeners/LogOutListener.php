<?php

namespace App\Listeners;

use App\Events\LogOutAttendenceLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogOutListener
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
    public function handle(LogOutAttendenceLogger $event): void
    {

        Log::alert('user_logout:' . $event->user );
        $user_id = $event->user->id;

        DB::table("sm_staff_attendences")->updateOrInsert(
            [
                'attendence_date' => now()->format('Y-m-d'),
                'staff_id' =>  $event->user->staff->id,
            ],
            [
                'check_out' => now()->format('H:i'),
            ]
        );

    }
}
