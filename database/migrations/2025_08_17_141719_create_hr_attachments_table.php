<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->string('file_path');
            $table->string('file_type')->nullable(); 
            $table->string('original_name')->nullable(); 
            $table->timestamps();
            $table->index(['model_id', 'model_type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_attachments');
    }
};
