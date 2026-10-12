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
        Schema::create('leave_balance_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\LeaveType::class ,  'leave_type_id');
            $table->foreignIdFor( \App\Models\JobTitle::class ,  'job_title_id')->nullable();
            $table->string('min_hiring_duration_years' )->default('0');
            $table->unsignedBigInteger('full_time_balance')->nullable();
            $table->unsignedBigInteger('part_time_balance')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balance_configurations');
    }
};
