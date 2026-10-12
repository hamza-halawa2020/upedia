<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_request_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('from_department_id')
                ->constrained('sm_human_departments')
                ->onDelete('cascade');
            $table->foreignId('to_department_id')
                ->constrained('sm_human_departments')
                ->onDelete('cascade');
            $table->string('profile_type')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_request_type');
    }
};