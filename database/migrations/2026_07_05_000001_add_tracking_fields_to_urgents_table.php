<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('urgents', function (Blueprint $table) {
            $table->string('type')->nullable()->after('message');
            $table->string('source')->nullable()->after('type');
            $table->json('metadata')->nullable()->after('source');
        });
    }

    public function down(): void
    {
        Schema::table('urgents', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'source',
                'metadata',
            ]);
        });
    }
};
