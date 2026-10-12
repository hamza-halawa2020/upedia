<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->enum('status', ['solved','not_solved'])->default('not_solved')->after('priority');
        });
    }
    public function down(): void
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};