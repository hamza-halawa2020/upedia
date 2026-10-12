<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\StaffScheduled;
use App\Models\ScheduledSession;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->foreignIdFor(User::class,'admin_id')->nullable()->constrained();
            $table->foreignIdFor(StaffScheduled::class,'course_id')->nullable()->constrained();
            $table->foreignIdFor(ScheduledSession::class,'session_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['session_id']);
        });
    }
};
