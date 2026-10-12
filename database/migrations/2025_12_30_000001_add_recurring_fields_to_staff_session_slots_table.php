<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_session_slots', function (Blueprint $table) {
            $table->enum('session_type', ['demo', 'training', 'induction'])->default('demo')->after('end_time');
        });
    }

    public function down(): void
    {
        Schema::table('staff_session_slots', function (Blueprint $table) {
            $table->dropColumn(['session_type']);
        });
    }
};