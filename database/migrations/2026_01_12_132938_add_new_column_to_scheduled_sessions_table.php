<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Staff;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            $table->foreignIdFor(Staff::class, 'staff_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
             $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }
};
