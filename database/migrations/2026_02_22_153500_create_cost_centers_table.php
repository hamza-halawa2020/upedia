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
        Schema::create('cost_centers', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('code')->unique();
            $blueprint->string('title');
            $blueprint->string('slug')->unique();
            $blueprint->string('status')->default('Active'); // Active / Inactive
            $blueprint->unsignedBigInteger('created_by')->nullable();
            $blueprint->timestamps();
            $blueprint->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_centers');
    }
};
