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
        Schema::create('escalation_request_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escalation_request_id')
                ->constrained('escalation_requests')
                ->cascadeOnDelete();
            $table->string('action')->default('status_updated')->index();
            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')
                ->on('sm_staffs')
                ->nullOnDelete();
            $table->index(['escalation_request_id', 'created_at'], 'esc_req_hist_req_created_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalation_request_histories');
    }
};
