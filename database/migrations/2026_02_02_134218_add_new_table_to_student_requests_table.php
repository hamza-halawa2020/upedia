<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->enum('status',['pending','solved','unsolved'])->default('pending');
            $table->foreignIdFor(User::class,'status_changed_by')->nullable()->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_changed_by');
        });
    }
};
