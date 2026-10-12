<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Tickets\Actions\SendTicketReminders;
use Modules\Notifications\Actions\NotifyActor;
use Tests\TestCase;

class TicketReminderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(now()->setDate(2026, 10, 12)->setTime(10, 0));
        Schema::create('firebase_notification_configs', function (Blueprint $table) {
            $table->id();
            foreach (['first_notification_before', 'second_notification_after', 'working_hour_start', 'working_hour_end'] as $name) {
                $table->integer($name);
            }
        });
        Schema::create('hr_job_titles', function (Blueprint $table) {
            $table->id(); $table->string('slug');
        });
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id'); $table->unsignedBigInteger('job_title_id');
        });
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); $table->string('status'); $table->dateTime('resolution_time')->nullable();
            $table->integer('remaining_time')->nullable();
            $table->boolean('first_notification_sent')->default(false);
            $table->boolean('second_notification_sent')->default(false); $table->timestamps();
        });
        DB::table('firebase_notification_configs')->insert([
            'first_notification_before' => 30, 'second_notification_after' => 5,
            'working_hour_start' => 8, 'working_hour_end' => 16,
        ]);
        DB::table('sm_human_departments')->insert(['id' => 29, 'name' => 'IT', 'slug' => 'it']);
        DB::table('hr_job_titles')->insert(['id' => 1, 'slug' => 'it-manager']);
        $user = User::create(['full_name' => 'Manager', 'email' => 'reminder@example.test', 'password' => bcrypt('test')]);
        DB::table('sm_staffs')->insert([
            'first_name' => 'IT', 'last_name' => 'Manager', 'full_name' => 'IT Manager',
            'email' => 'it@example.test', 'user_id' => $user->id, 'department_id' => 29, 'job_title_id' => 1,
        ]);
    }

    public function test_reminder_stages_are_sent_once_and_closed_tickets_are_excluded(): void
    {
        DB::table('tickets')->insert([
            ['id' => 1, 'status' => 'open', 'resolution_time' => '2026-10-12 10:20:00'],
            ['id' => 2, 'status' => 'open', 'resolution_time' => '2026-10-12 09:50:00'],
            ['id' => 3, 'status' => 'closed', 'resolution_time' => '2026-10-12 09:50:00'],
        ]);
        $this->mock(NotifyActor::class)->shouldReceive('handle')->twice();
        $this->assertSame(2, app(SendTicketReminders::class)->handle());
        $this->assertSame(0, app(SendTicketReminders::class)->handle());
        $this->assertDatabaseHas('tickets', ['id' => 1, 'first_notification_sent' => 1, 'remaining_time' => 20]);
        $this->assertDatabaseHas('tickets', ['id' => 2, 'second_notification_sent' => 1, 'remaining_time' => -10]);
        $this->assertDatabaseHas('tickets', ['id' => 3, 'second_notification_sent' => 0]);
    }

    public function test_missing_manager_does_not_consume_escalation_and_weekends_skip(): void
    {
        DB::table('hr_job_titles')->update(['slug' => 'it-support']);
        DB::table('tickets')->insert(['id' => 1, 'status' => 'open', 'resolution_time' => '2026-10-12 09:00:00']);
        $this->mock(NotifyActor::class)->shouldNotReceive('handle');
        $this->assertSame(0, app(SendTicketReminders::class)->handle());
        $this->assertDatabaseHas('tickets', ['id' => 1, 'second_notification_sent' => 0]);
        $this->travelTo(now()->setDate(2026, 10, 16));
        $this->assertSame(0, app(SendTicketReminders::class)->handle());
    }
}
