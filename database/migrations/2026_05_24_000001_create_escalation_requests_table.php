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
        Schema::create('escalation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_department_id')
                ->constrained('sm_human_departments')
                ->restrictOnDelete();
            $table->foreignId('to_department_id')
                ->constrained('sm_human_departments')
                ->restrictOnDelete();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('status')->default('pending')->index();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('sm_staffs')
                ->nullOnDelete();
            $table->foreign('created_by')
                ->references('id')
                ->on('sm_staffs')
                ->restrictOnDelete();
            $table->foreign('updated_by')
                ->references('id')
                ->on('sm_staffs')
                ->nullOnDelete();
            $table->index(['to_department_id', 'assigned_to']);
            $table->index(['from_department_id', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalation_requests');
    }
};
