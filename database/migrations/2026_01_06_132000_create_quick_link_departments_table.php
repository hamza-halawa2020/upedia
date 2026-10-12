<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quick_link_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quick_link_id')->constrained('quick_links')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('sm_human_departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quick_link_departments');
    }
};
