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
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->string('video')->nullable();
            $table->string('poster')->nullable();
            $table->string('user_image')->nullable();
            $table->string('reader_image')->nullable();
            $table->integer('favourite_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->boolean('status')->default(0);
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
