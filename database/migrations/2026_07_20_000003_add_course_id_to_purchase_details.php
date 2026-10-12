<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('purchase_details') || Schema::hasColumn('purchase_details', 'course_id')) {
            return;
        }

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable()->after('booking_id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('purchase_details') || !Schema::hasColumn('purchase_details', 'course_id')) {
            return;
        }

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropColumn('course_id');
        });
    }
};
