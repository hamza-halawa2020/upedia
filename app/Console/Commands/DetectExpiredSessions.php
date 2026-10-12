<?php

namespace App\Console\Commands;

use App\Models\AuthEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetectExpiredSessions extends Command
{
    protected $signature = 'sessions:detect-expired';

    protected $description = 'Detect expired sessions and store logout audit events';

    public function handle(): int
    {
      
        $lifetimeInSeconds = config('session.lifetime') * 60;
        $expirationCutoff  = now()->timestamp - $lifetimeInSeconds;


    $collect = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '<', $expirationCutoff)

            ->orderBy('last_activity')
            ->limit(500)
            ->get()
            ->each(function ($session) {
             if( AuthEvent::where(['session_id' => $session->id , 'user_id' =>  $session->user_id] )->exists()) return;

            $event =
                AuthEvent::firstOrCreate(
                [
                    'user_id' => $session->user_id,
                    'event_type' => 'logout',
                    'session_id' => $session->id,
                    'created_at' => now(),
                ]
                ,
                [
                    'user_id'    => $session->user_id,
                    'event_type' => 'logout',
                    'logout_reason'     => 'session_expired',
                    'created_at' => now(),
                ]);
            Log::alert('user_logout:' . $event->user );
            });

        return self::SUCCESS;
    }
}
