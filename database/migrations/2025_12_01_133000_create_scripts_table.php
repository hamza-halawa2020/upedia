<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category_name');
            // Public or Private
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->enum('status', ['approved', 'unapproved'])->default('unapproved');

            // department relation
            $table->unsignedBigInteger('department_id');
            // keywords (nullable)
            $table->string('keywords')->nullable();

            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('sm_human_departments')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};
