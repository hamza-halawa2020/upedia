<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackTypeSeeder extends Seeder
{
    public function run(): void
    {
        $trackTypes = [
            [
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'Group adults +17',
                'count_of_students' => 12,
                'name_ar' => 'Group adults +17',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">2-Hour Sessions · 6–8 Learners</strong></p><p><em style="color: rgb(91, 100, 114);">Real conversations, real confidence — powered by peer energy.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">2-hour interactive sessions designed for effective learning and practice</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with 6–8 learners who share common learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Practice English through real conversations and meaningful discussions</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Engage in interactive activities, pair work, and collaborative tasks</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Develop confidence by speaking and communicating with your peers</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn from different ideas, experiences, and perspectives</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A motivating, supportive, and social learning environment</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A structured learning experience with great value for money</span></p>
                    HTML,
                'slug' => 'group-adults',
                'can_delete' => 'no',
            ],
            [
                'id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'group kids 5 to 11',
                'count_of_students' => 8,
                'name_ar' => 'group kids 5 to 11',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">2-Hour Sessions · 6–8 Learners</strong></p><p><em style="color: rgb(91, 100, 114);">Real conversations, real confidence — powered by peer energy.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">2-hour interactive sessions designed for effective learning and practice</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with 6–8 learners who share common learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Practice English through real conversations and meaningful discussions</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Engage in interactive activities, pair work, and collaborative tasks</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Develop confidence by speaking and communicating with your peers</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn from different ideas, experiences, and perspectives</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A motivating, supportive, and social learning environment</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A structured learning experience with great value for money</span></p>
                    HTML,
                'slug' => 'group-kids',
                'can_delete' => 'no',
            ],
            [
                'id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'group teens 12 to 16',
                'count_of_students' => 5,
                'name_ar' => 'group teens 12 to 16',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">2-Hour Sessions · 6–8 Learners</strong></p><p><em style="color: rgb(91, 100, 114);">Real conversations, real confidence — powered by peer energy.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">2-hour interactive sessions designed for effective learning and practice</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with 6–8 learners who share common learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Practice English through real conversations and meaningful discussions</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Engage in interactive activities, pair work, and collaborative tasks</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Develop confidence by speaking and communicating with your peers</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn from different ideas, experiences, and perspectives</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A motivating, supportive, and social learning environment</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A structured learning experience with great value for money</span></p>
                    HTML,
                'slug' => 'group-teens',
                'can_delete' => 'no',
            ],
            [
                'id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'private adults +17',
                'count_of_students' => 1,
                'name_ar' => 'private adults +17',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">60-Minute Sessions · 1-on-1</strong></p><p><em style="color: rgb(91, 100, 114);">One-on-one with your own teacher — fully customized to your level and goals.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">One-on-one, interactive 60-minute sessions with your dedicated teacher</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your individual needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around your level, goals, and specific needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor your progress and adjust your learning plan</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Flexible scheduling that works around your time</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Faster progress with your teacher's full attention</span></p>
                    HTML,
                'slug' => 'private-adults',
                'can_delete' => 'no',
            ],
            [
                'id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'private kids 5 to 11',
                'count_of_students' => 1,
                'name_ar' => 'private kids 5 to 11',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">60-Minute Sessions · 1-on-1</strong></p><p><em style="color: rgb(91, 100, 114);">One-on-one with your own teacher — fully customized to your level and goals.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">One-on-one, interactive 60-minute sessions with your dedicated teacher</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your individual needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around your level, goals, and specific needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor your progress and adjust your learning plan</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Flexible scheduling that works around your time</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Faster progress with your teacher's full attention</span></p>
                    HTML,
                'slug' => 'private-kids',
                'can_delete' => 'no',
            ],
            [
                'id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'private teens 12 to 16',
                'count_of_students' => 1,
                'name_ar' => 'private teens 12 to 16',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">60-Minute Sessions · 1-on-1</strong></p><p><em style="color: rgb(91, 100, 114);">One-on-one with your own teacher — fully customized to your level and goals.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">One-on-one, interactive 60-minute sessions with your dedicated teacher</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your individual needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around your level, goals, and specific needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor your progress and adjust your learning plan</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Flexible scheduling that works around your time</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Faster progress with your teacher's full attention</span></p>
                    HTML,
                'slug' => 'private-teens',
                'can_delete' => 'no',
            ],
            [
                'id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'semi-private adults +17',
                'count_of_students' => 2,
                'name_ar' => 'semi-private adults +17',
                'description' => <<<'HTML'
                    <p><strong style="background-color: rgb(230, 244, 242); color: rgb(14, 143, 130);">60-Minute Sessions · Pairs</strong></p><p><em style="color: rgb(91, 100, 114);">Learn together, progress faster — with a partner who matches your level.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with a partner who shares your level and learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Interactive 60-minute sessions designed for two learners</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your shared learning needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around both learners' level, goals, and needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Personal attention with more opportunities to interact, practice, and communicate</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor both learners' progress</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn together, practice together, and make progress together</span></p>
                    HTML,
                'slug' => 'semi-private-adults',
                'can_delete' => 'no',
            ],
            [
                'id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'semi-private kids 5 to 11',
                'count_of_students' => 2,
                'name_ar' => 'semi-private kids 5 to 11',
                'description' => <<<'HTML'
                    <p><strong style="color: rgb(14, 143, 130); background-color: rgb(230, 244, 242);">60-Minute Sessions · Pairs</strong></p><p><em style="color: rgb(91, 100, 114);">Learn together, progress faster — with a partner who matches your level.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with a partner who shares your level and learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Interactive 60-minute sessions designed for two learners</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your shared learning needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around both learners' level, goals, and needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Personal attention with more opportunities to interact, practice, and communicate</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor both learners' progress</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn together, practice together, and make progress together</span></p>
                    HTML,
                'slug' => 'semi-private-kids',
                'can_delete' => 'no',
            ],
            [
                'id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'semi-private teens 12 to 16',
                'count_of_students' => 2,
                'name_ar' => 'semi-private teens 12 to 16',
                'description' => <<<'HTML'
                    <p><strong style="background-color: rgb(230, 244, 242); color: rgb(14, 143, 130);">60-Minute Sessions · Pairs</strong></p><p><em style="color: rgb(91, 100, 114);">Learn together, progress faster — with a partner who matches your level.</em></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn with a partner who shares your level and learning goals</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Interactive 60-minute sessions designed for two learners</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">70% structured course content + 30% focused on your shared learning needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">A tailored learning plan designed around both learners' level, goals, and needs</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Personal attention with more opportunities to interact, practice, and communicate</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Continuous follow-up to monitor both learners' progress</span></p><p><strong style="color: rgb(14, 143, 130);">✓&nbsp;</strong><span style="color: rgb(31, 36, 48);">Learn together, practice together, and make progress together</span></p>
                    HTML,
                'slug' => 'semi-private-teens',
                'can_delete' => 'no',
            ],
        ];

        DB::transaction(function () use ($trackTypes): void {
            foreach ($trackTypes as $trackType) {
                DB::table('track_types')->updateOrInsert(
                    ['id' => $trackType['id']],
                    $trackType,
                );
            }
        });
    }
}
