<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\IT\Tickets\Queries\TicketStaff;
use Tests\TestCase;

class TicketStaffDetailsTest extends TestCase
{
    public function test_staff_details_include_manager_and_phone_without_lazy_queries(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mobile_dial_code')->nullable();
            $table->string('home_phone')->nullable();
        });
        DB::table('sm_human_departments')->insert(['id' => 1, 'name' => 'IT']);
        foreach ([1 => 'Worker', 2 => 'Manager'] as $id => $name) {
            DB::table('sm_staffs')->insert([
                'id' => $id, 'user_id' => $id, 'full_name' => $name, 'first_name' => $name,
                'last_name' => 'Test', 'email' => $name.'@example.test', 'department_id' => 1,
                'manager_id' => $id === 1 ? 2 : null, 'mobile' => $id === 1 ? '12345' : null,
                'mobile_dial_code' => $id === 1 ? '+20' : null,
            ]);
        }
        DB::enableQueryLog();
        $data = app(TicketStaff::class)->details(1);
        $this->assertSame('Manager', $data['manager_name']);
        $this->assertSame('+20 12345', $data['phone']);
        $this->assertSame('IT', $data['department_name']);
        $this->assertCount(3, DB::getQueryLog());
        DB::disableQueryLog();
        $data = app(TicketStaff::class)->details(2);
        $this->assertNull($data['manager_name']);
        $this->assertNull($data['phone']);
    }
}
