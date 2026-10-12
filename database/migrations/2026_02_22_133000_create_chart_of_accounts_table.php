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
        Schema::create('chart_of_accounts', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('code')->unique();
            $blueprint->string('title');
            $blueprint->string('slug')->unique();
            $blueprint->unsignedBigInteger('parent_id')->nullable();
            $blueprint->string('status')->default('Active'); // Active / Inactive
            $blueprint->unsignedBigInteger('created_by')->nullable();
            $blueprint->boolean('can_delete')->default(true);
            $blueprint->boolean('is_system')->default(false);
            $blueprint->timestamps();

            $blueprint->foreign('parent_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $blueprint->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
