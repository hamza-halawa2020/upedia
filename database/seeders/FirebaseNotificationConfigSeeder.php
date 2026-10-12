<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirebaseNotificationConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                'id' => 1,
                'first_notification_before' => 30,
                'second_notification_after' => 5,
                'working_hour_start' => 9,
                'working_hour_end' => 17,
            ],
            [
                'id' => 2,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 3,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 4,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 5,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 6,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 7,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
            [
                'id' => 8,
                'first_notification_before' => 30,
                'second_notification_after' => 30,
                'working_hour_start' => 8,
                'working_hour_end' => 16,
            ],
        ];

        foreach ($configs as $config) {
            $config['created_at'] = now();
            $config['updated_at'] = now();

            DB::table('firebase_notification_configs')->updateOrInsert(
                ['id' => $config['id']],
                $config
            );
        }
    }
}
