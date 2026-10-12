<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hr_request_recruitments', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('role_description')->nullable();
            $table->json('track_type_ids')->nullable()->after('category_id')->nullable();
            $table->json('track_ids')->nullable()->after('track_type_ids')->nullable();
            $table->json('shift_time_ids')->nullable()->after('track_ids')->nullable();
            $table->enum('shift_time', ['morning', 'night'])->nullable()->after('shift_time_ids')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_request_recruitments', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'track_type_ids', 'track_ids', 'shift_time_ids', 'shift_time']);
        });
    }
};
