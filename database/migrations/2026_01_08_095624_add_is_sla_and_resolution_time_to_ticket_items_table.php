<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->boolean('is_sla')->default(false)->after('ticket_category_id');
            $table->integer('resolution_time')->nullable()->after('is_sla');
        });
    }
    public function down(): void
    {
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->dropColumn(['is_sla', 'resolution_time']);
        });
    }
};