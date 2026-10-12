<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_evaluations', function (Blueprint $table) {
            $table->id();
            
            $table->text('rating')->nullable();

            $table->string('comment')->nullable();

            $table->boolean('status')->nullable()->default(false);

            $table->unsignedBigInteger('record_id')->unsigned();
            
            $table->unsignedBigInteger('subject_id')->nullable()->unsigned();
            
            $table->unsignedBigInteger('teacher_id')->nullable()->unsigned();
            
            $table->unsignedBigInteger('student_id')->nullable()->unsigned();
            
            $table->unsignedBigInteger('role_id')->nullable()->unsigned();
            
            $table->unsignedBigInteger('parent_id')->nullable()->unsigned();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_evaluations');
    }
}
