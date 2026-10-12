<?php

namespace Database\Seeders;

use App\Models\TrackType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('slot_emps')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // private , Group Adult , Group teens 

        $privateTrackType = TrackType::where('slug',  'private-adults')->firstOrFail()->id;
        $semiPrivateTrackType = TrackType::where('slug',  'semi-private-adults')->firstOrFail()->id;
        $groupAdultTrackType = TrackType::where('slug',  'group-adults')->firstOrFail()->id;
        $groupTeensTrackType = TrackType::where('slug',  'group-teens')->firstOrFail()->id;


        $teacherTimeSlots = [
            // saturday
            ['slot_day' => 'saturday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan','summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],


            ['slot_day' => 'saturday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'saturday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],



            // sunday
            ['slot_day' => 'sunday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'sunday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],



            // Monday
            ['slot_day' => 'monday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'monday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],




            // tuesday
            ['slot_day' => 'tuesday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'tuesday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],


            // wednesday
            ['slot_day' => 'wednesday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'wednesday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],



            // thursday
            ['slot_day' => 'thursday', 'slot_start' => '10:00:00', 'slot_end' => '11:00:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '11:00:00', 'slot_end' => '12:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '12:00:00', 'slot_end' => '13:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '15:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '17:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '12:15:00', 'slot_end' => '13:15:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '13:15:00', 'slot_end' => '14:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '14:15:00', 'slot_end' => '15:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '18:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'morning', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '14:30:00', 'slot_end' => '15:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '15:30:00', 'slot_end' => '16:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '16:30:00', 'slot_end' => '17:30:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '17:00:00', 'slot_end' => '18:00:00', 'type' => 'teacher', 'season' => ['winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '18:00:00', 'slot_end' => '19:00:00', 'type' => 'teacher', 'season' => ['summer', 'winter'], 'timing_type' => 'morning', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '19:00:00', 'slot_end' => '20:00:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '20:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '21:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['summer'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '22:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['summer', 'winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '23:30:00', 'slot_end' => '00:30:00', 'type' => 'teacher', 'season' => ['summer', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '21:30:00', 'slot_end' => '22:30:00', 'type' => 'teacher', 'season' => ['winter', 'ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '19:15:00', 'slot_end' => '21:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupAdultTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '21:30:00', 'slot_end' => '23:30:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '20:15:00', 'slot_end' => '22:15:00', 'type' => 'teacher', 'season' => ['winter','summer'], 'timing_type' => 'night', 'track_type_id' => [$groupTeensTrackType],],
            ['slot_day' => 'thursday', 'slot_start' => '19:15:00', 'slot_end' => '20:15:00', 'type' => 'teacher', 'season' => ['winter','ramadan'], 'timing_type' => 'night', 'track_type_id' => [$privateTrackType, $semiPrivateTrackType],],

            // Add more entries for the rest of the days manually
        ];
        $testerTimeSlots = [];
        $testerDays = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];
        foreach ($testerDays as $day) {
            $currentTime = \Carbon\Carbon::createFromTime(11, 0, 0);
            $endTime = \Carbon\Carbon::createFromTime(0, 0, 0)->addDay(); // 12:00 AM next day

            while ($currentTime < $endTime) {
                // Determine timing type based on start time (19:00 and later is night)
                $timing_type = $currentTime->hour >= 19 ? 'night' : 'morning';

                $slotStart = $currentTime->format('H:i:s');
                $slotEnd = clone $currentTime;
                $slotEnd->addMinutes(25);

                $testerTimeSlots[] = [
                    'slot_day' => $day,
                    'slot_start' => $slotStart,
                    'slot_end' => $slotEnd->format('H:i:s'),
                    'type' => 'tester',
                    'timing_type' => $timing_type,
                ];

                $currentTime->addMinutes(25);
            }
        }


        foreach ($teacherTimeSlots as &$slot) {
            $slot['season'] = json_encode($slot['season']);
            $slot['track_type_id'] = json_encode($slot['track_type_id']);

        }
        foreach ($testerTimeSlots as &$slot) {

            $slot['timing_type'] = 'morning';


            $slot['season'] = json_encode(['summer', 'winter', 'ramadan']);
        }

        DB::table('slot_emps')->insert($teacherTimeSlots);
        DB::table('slot_emps')->insert($testerTimeSlots);
    }
}
