<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hr_shared_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('folder_id');
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->date('valid_until')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('share_department_id')->nullable();
            $table->unsignedBigInteger('share_staff_id')->nullable();
            $table->string('attachment_type');
            $table->string('attachment');
            $table->enum('notifications', ['email', 'feeds'])->nullable();
            $table->timestamps();
            $table->foreign('folder_id')->references('id')->on('hr_shared_center_folders')->onDelete('cascade');
            $table->foreign('share_department_id')->references('id')->on('sm_human_departments')->onDelete('set null');
            $table->foreign('share_staff_id')->references('id')->on('sm_staffs')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hr_shared_centers');
    }
};
