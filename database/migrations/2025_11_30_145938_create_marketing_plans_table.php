<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketing_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('sm_staffs')->onDelete('cascade');

            $table->string('name');
            $table->string('subject');
            $table->string('month')->nullable();
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->enum('status', ['draft', 'under-review', 'ready-to-publish', 'not-approved', 'published'])->default('draft');
            $table->enum('platform', ['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram']);
            $table->enum('type', ['script', 'content_plan', 'design', 'video'])->default('script');

            $table->text('description')->nullable();
            $table->text('comments')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('marketing_plans');
    }
};
