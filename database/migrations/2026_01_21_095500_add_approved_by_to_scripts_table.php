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
        Schema::table('scripts', function (Blueprint $col) {
            $col->unsignedBigInteger('approved_by')->nullable()->after('created_by');
            $col->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scripts', function (Blueprint $col) {
            $col->dropForeign(['approved_by']);
            $col->dropColumn('approved_by');
        });
    }
};
