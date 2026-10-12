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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_id');
            $table->unsignedBigInteger('created_by');
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('source')->nullable();
            $table->string('resume')->nullable();

            $table->enum('current_status',['new','rejected','hired','offer_rejected'])->default('new');

            $table->enum('screening_status', ['pending', 'done', 'rejected'])->default('pending');
            $table->enum('phone_call_status', ['pending', 'done', 'rejected'])->default('pending');
            $table->enum('shortlist_status', ['pending', 'done', 'rejected'])->default('pending');
            $table->enum('demo_scheduling_status', ['pending', 'done', 'rejected'])->default('pending');

            $table->enum('stage_status', ['induction', 'training', 'rejected', 'rescheduling','pending'])->default('pending');
            $table->boolean('is_resheduled')->default(false);

            $table->enum('stage_result', ['passed', 'failed'])->nullable();

            $table->boolean('final_interview_done')->default(false);
            $table->enum('offer_status', ['pending', 'accepted', 'rejected'])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
