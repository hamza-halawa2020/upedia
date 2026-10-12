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
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);

            $table->unsignedBigInteger('instructor_id')->nullable()->change();

            $table->foreign('instructor_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {

            $table->dropForeign(['instructor_id']);

            $table->unsignedBigInteger('instructor_id')->nullable(false)->change();

            $table->foreign('instructor_id')->references('id')->on('sm_staffs')->onDelete('cascade');
        });
    }
};
