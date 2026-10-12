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
        Schema::create('escalation_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escalation_request_id')
                ->constrained('escalation_requests')
                ->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('sm_staffs')
                ->nullOnDelete();
            $table->index(['escalation_request_id', 'uploaded_by'], 'esc_req_attach_req_uploaded_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escalation_request_attachments');
    }
};
