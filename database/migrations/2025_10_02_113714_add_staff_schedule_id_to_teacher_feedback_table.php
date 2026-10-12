<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_schedule_id')->after('teacher_id');

            $table->foreign('staff_schedule_id')
                ->references('id')
                ->on('staff_scheduleds')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_feedback', function (Blueprint $table) {
            $table->dropForeign(['staff_schedule_id']);
            $table->dropColumn('staff_schedule_id');
        });
    }
};
