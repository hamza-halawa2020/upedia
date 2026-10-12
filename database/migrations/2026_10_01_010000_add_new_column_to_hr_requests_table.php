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
        Schema::table('hr_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->after('details');
            $table->enum('status', ['pending', 'in_progress', 'done', 'rejected'])->default('pending')->after('student_id');
            $table->string('notes')->nullable()->after('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_requests', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('notes');
        });
    }
};
