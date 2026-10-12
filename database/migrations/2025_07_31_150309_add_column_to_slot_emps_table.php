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
        Schema::table('slot_emps', function (Blueprint $table) {
            $table->json('track_type_id')->after('id')->nullable();
            $table->enum('season', ['summer', 'winter','ramadan'])->after('track_type_id')->default('summer');
            $table->enum('timing_type', ['morning', 'night'])->after('season')->default('morning');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slot_emps', function (Blueprint $table) {
            $table->dropColumn('track_type_id');
            $table->dropColumn('season');
            $table->dropColumn('timing_type');
        });
    }
};
