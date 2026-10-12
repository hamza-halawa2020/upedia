<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_request_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_request_id')->constrained('student_requests')->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('status_note')->nullable();
            $table->unsignedBigInteger('status_changed_by')->nullable();
            $table->boolean('deduct_admin_expenses')->default(false);
            $table->decimal('additional_amount', 12, 2)->default(0);
            $table->unsignedBigInteger('performed_by_user_id')->nullable();
            $table->timestamps();

            $table->foreign('status_changed_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('performed_by_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_request_histories');
    }
};

