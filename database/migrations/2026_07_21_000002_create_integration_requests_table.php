<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('integration_requests')) {
            return;
        }

        Schema::create('integration_requests', function (Blueprint $table) {
            $table->id();
            $table->string('idempotency_key')->unique();
            $table->string('source_service', 80)->nullable()->index();
            $table->string('source_type', 80)->nullable()->index();
            $table->string('source_id', 120)->nullable()->index();
            $table->string('external_reference')->nullable()->index();
            $table->string('operation', 80)->index();
            $table->string('request_hash', 64);
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->json('response_body')->nullable();
            $table->string('resource_type')->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('status', 20)->default('processing')->index();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['operation', 'source_service', 'source_type', 'source_id'], 'integration_requests_source_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_requests');
    }
};
