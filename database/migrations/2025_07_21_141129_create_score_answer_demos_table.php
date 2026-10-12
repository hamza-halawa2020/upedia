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
        Schema::create('score_answer_demos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->tinyInteger('score')->default(0);
            $table->string('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_answer_demos');
    }
};
