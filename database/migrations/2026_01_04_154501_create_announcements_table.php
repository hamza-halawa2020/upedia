<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->date('expiry_date')->nullable();
            $table->unsignedBigInteger('is_commentable')->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('notify_all')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
