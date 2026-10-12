<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_regularizations_permissions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['regularizations', 'permissions']);
            $table->unsignedBigInteger('staff_id');
            $table->date('date');
            $table->time('from_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('reason')->nullable();
            $table->text('permission');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_regularizations_permissions');
    }
};
