<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quick_links', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('link');
            $table->boolean('is_active')->default(true)->after('created_by');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('quick_links', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['created_by', 'is_active']);
        });
    }
};
