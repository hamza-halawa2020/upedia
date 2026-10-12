<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('retention_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->boolean('camera_off')->default(false);
            $table->boolean('internet_not_stable')->default(false);
            $table->boolean('class_room_not_suitable')->default(false);
            $table->boolean('on_spot_absence')->default(false);
            $table->boolean('delay_in_start')->default(false);
            $table->text('admin_comments')->nullable();
            $table->timestamps();
            $table->foreign('staff_id')
                  ->references('id')
                  ->on('sm_staffs')  
                  ->onDelete('cascade');

            $table->foreign('session_id')
                  ->references('id')
                  ->on('scheduled_sessions')
                  ->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('retention_feedback');
    }
};
