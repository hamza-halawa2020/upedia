<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\JobTitle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_target_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignIdFor(User::class, 'created_by');
            $table->foreignIdFor(JobTitle::class, 'job_title_id');
            $table->enum('target_type', ['number', 'percentage']);
            $table->unsignedBigInteger('target_from');
            $table->unsignedBigInteger('target_to');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_target_configurations');
    }
};
