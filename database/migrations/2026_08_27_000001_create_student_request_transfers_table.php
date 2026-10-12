<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_request_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_request_id');
            $table->unsignedBigInteger('from_department_id')->nullable();
            $table->unsignedBigInteger('to_department_id')->nullable();
            $table->unsignedBigInteger('transferred_by')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('student_request_id');
            $table->index('from_department_id');
            $table->index('to_department_id');
            $table->index('transferred_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_request_transfers');
    }
};
