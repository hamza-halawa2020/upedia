<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            $table->string('attached')->nullable()->after('status'); 
        });
    }
    public function down(): void
    {
        Schema::table('scheduled_sessions', function (Blueprint $table) {
            $table->dropColumn('attached');
        });
    }
};
