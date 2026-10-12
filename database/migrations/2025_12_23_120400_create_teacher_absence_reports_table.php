<?php

use App\Models\ScheduledSession;
use App\Models\Staff;
use App\Models\StaffScheduled;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teacher_absence_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ScheduledSession::class, 'old_session_id');
            $table->foreignIdFor(Staff::class, 'teacher_id');
            $table->foreignIdFor(StaffScheduled::class, 'new_staff_scheduled_id');
            $table->foreignIdFor(User::class, 'created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_absence_reports');
    }
};
