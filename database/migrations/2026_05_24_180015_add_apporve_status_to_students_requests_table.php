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
//        Schema::table('student_requests', function (Blueprint $table) {
//
//            DB::statement("ALTER TABLE student_requests MODIFY status ENUM('pending','approved','assigned','in_progress','resolved','rejected','closed') NOT NULL DEFAULT 'pending'");
//            $table->tinyInteger( 'academy_assigned_id')->nullable();
//
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::table('student_requests', function (Blueprint $table) {
//            $table->dropColumn('academy_assigned_id');
//            $table->dropColumn("status");
//        });
    }
};
