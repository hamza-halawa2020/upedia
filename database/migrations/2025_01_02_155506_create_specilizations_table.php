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
        Schema::create('specilizations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->unsignedBigInteger('created_by')->nullable()->default(1);

            $table->unsignedBigInteger('updated_by')->nullable()->default(1);

            $table->unsignedBigInteger('is_saas')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specilizations');
    }
};
