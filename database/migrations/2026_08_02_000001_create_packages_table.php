<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedTinyInteger('levels_count');
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->unsignedBigInteger('display_order')->index();
            $table->timestamps();

            $table->unique('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
