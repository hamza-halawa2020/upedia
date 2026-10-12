<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('device_token');
            $table->string('token_hash', 64);
            $table->string('device_type')->default('web');
            $table->text('device_name')->nullable();
            $table->string('project')->default('setting');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'token_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_device_tokens');
    }
};