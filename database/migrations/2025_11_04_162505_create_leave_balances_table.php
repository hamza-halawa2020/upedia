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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->unsignedBigInteger('balance_days')->default(0);
            $table->unsignedBigInteger('used_days')->default(0);
            $table->year('year')->default(now()->year);
            $table->timestamps();

            $table->unique(['staff_id', 'leave_type_id', 'year']);
            $table->index(['staff_id']);
            $table->index(['leave_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
