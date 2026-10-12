<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->time('resolution_time')->nullable()->after('status');
            $table->integer('item_resolution_time')->nullable()->after('resolution_time');
            $table->timestamp('closed_at')->nullable()->after('item_resolution_time');
        });
    }
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'resolution_time',
                'item_resolution_time',
                'closed_at',
            ]);
        });
    }
};
