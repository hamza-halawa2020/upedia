<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_distribution_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('distribution_method', ['automatic', 'percentage', 'manual'])->default('manual');
            $table->unsignedBigInteger('morning_shift_capacity')->nullable();
            $table->unsignedBigInteger('evening_shift_capacity')->nullable();
            $table->foreignIdFor(\App\Models\Staff::class, 'created_by')->nullable();
            $table->foreignIdFor(\App\Models\Staff::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_distribution_settings');
    }
};
