<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('due_date')->nullable();
            $table->date('reminder')->nullable();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->string('task_type')->nullable();
            $table->integer('progress')->default(0);
            $table->string('attachments')->nullable();
            $table->enum('status', ['open', 'hold', 'closed'])->default('open');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('staff_id')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_tasks');
    }
};
