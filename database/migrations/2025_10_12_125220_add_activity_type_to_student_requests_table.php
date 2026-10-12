<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->enum('activity_type', ['gift_call', 'english_club'])->nullable()->after('related_to');
            $table->date('date')->nullable()->after('activity_type');
            $table->time('time')->nullable()->after('date');
            $table->time('change_time')->nullable()->after('time');
        });
    }
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropColumn('activity_type');
        });
    }
};
