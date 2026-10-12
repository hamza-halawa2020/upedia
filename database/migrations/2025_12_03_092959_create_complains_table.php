<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('sm_staffs')->onDelete('cascade');
            $table->enum('platform', ['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram']);
            $table->date('date');
            $table->string('sales');
            $table->string('system');
            $table->string('client_name');
            $table->string('client_number');
            $table->text('note')->nullable();
            $table->text('moderator_note')->nullable();
            $table->enum('inside_outside', ['inside', 'outside']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('complains');
    }
};