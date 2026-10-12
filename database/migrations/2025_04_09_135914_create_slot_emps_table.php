<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //2025_04_09_135914_create_slot_emps_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slot_emps', function (Blueprint $table) {
            $table->id();
            $table->string('slot_day');
            $table->time('slot_start');
            $table->time('slot_end');
            $table->timestamps();

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            // $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->integer('is_saas')->nullable()->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_emps');
    }
};
