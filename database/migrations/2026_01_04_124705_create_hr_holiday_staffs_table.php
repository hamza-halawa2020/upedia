<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hr_holiday_staffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hr_request_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('created_by');
            $table->date('date');
            $table->enum('type', ['holiday', 'work']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_holiday_staffs');
    }
};
