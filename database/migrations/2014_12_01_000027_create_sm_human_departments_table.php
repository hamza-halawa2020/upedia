<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmHumanDepartmentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('sm_human_departments', function (Blueprint $table) {
         $table->id();

         $table->string('name')->nullable();
         $table->tinyInteger('active_status')->default(1);
         $table->timestamps();

         $table->unsignedBigInteger('created_by')->nullable()->default(1)->unsigned();
         
         $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

         $table->unsignedBigInteger('updated_by')->nullable()->default(1)->unsigned();
         $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

         $table->integer('school_id')->nullable()->default(1)->unsigned();

         $table->integer('is_saas')->nullable()->default(0)->unsigned();
      });

   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('sm_human_departments');
   }
}
