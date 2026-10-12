<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('sm_human_departments')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('request_for');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreignId('request_type_id')->constrained('hr_request_type')->onDelete('cascade');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('deadline')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('request_for')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('track_levels')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_requests');
    }
};