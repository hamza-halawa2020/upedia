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
        Schema::table('staff_slots', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('slot_id');
            $table->enum('status', ['active', 'hold'])->default('active')->after('created_by');
            $table->unsignedBigInteger('track_type_id')->default(37)->after('status');
            $table->unsignedBigInteger('assigned_department_id')->nullable()->after('track_type_id');
            $table->unsignedBigInteger('assigned_id')->nullable()->after('assigned_department_id');
            $table->enum('timing', ['summer', 'winter', 'ramadan'])->default('summer')->after('assigned_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_slots', function (Blueprint $table) {
            $table->dropColumn([
                'created_by',
                'status',
                'track_type_id',
                'assigned_department_id',
                'assigned_id',
                'timing',
            ]);
        });
    }
};
