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
        Schema::create('currency_rate_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_rate_id');
            $table->string('currency');
            $table->decimal('old_rate', 15, 4)->nullable();
            $table->decimal('new_rate', 15, 4);
            $table->boolean('old_default')->nullable();
            $table->boolean('new_default');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rate_logs');
    }
};
