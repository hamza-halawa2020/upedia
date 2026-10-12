<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_mentions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Task::class , 'task_id');
            $table->foreignIdFor(\App\Models\Staff::class , 'staff_id');
            $table->string('job_title_slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_mentions');
    }
};
