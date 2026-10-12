<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            // $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('refund_manager_staff_id');
            $table->unsignedBigInteger('academy_assigned_id');
            $table->unsignedBigInteger('instructor_id');
            $table->foreign('created_by')->references('id')->on('sm_students')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->enum('type', ['complaint', 'request', 'need'])->nullable();
            $table->enum('related_to', ['activities', 'homework', 'whiteboard', 'curriculum', 'time'])->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('session')->nullable();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('student_requests');
    }
};