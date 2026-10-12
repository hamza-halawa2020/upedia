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
        if (!Schema::hasTable('sm_staff_attendences')) {
            Schema::create('sm_staff_attendences', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('staff_id');
                $table->date('attendence_date');
                $table->string('attendence_type', 10)->nullable()->comment('Present: P, Late: L, Absent: A, Holiday: H, Half Day: F');
                $table->text('notes')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();

                $table->foreign('staff_id')
                    ->references('id')->on('sm_staffs')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_staff_attendences');
    }
};
