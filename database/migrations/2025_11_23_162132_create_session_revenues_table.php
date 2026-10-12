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
        Schema::create('session_revenues', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('student_prepaid_id');

            $table->unsignedBigInteger('session_id');

            $table->decimal('session_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->integer('remaining_before');
            $table->integer('remaining_after');

            $table->integer('used_sessions');
            $table->decimal('progress_amount', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_revenues');
    }
};
