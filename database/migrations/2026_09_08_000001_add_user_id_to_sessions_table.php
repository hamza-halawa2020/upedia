<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table = config('session.table', 'sessions');

        if (! Schema::hasTable($table) || Schema::hasColumn($table, 'user_id')) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) {
            $blueprint->foreignId('user_id')->nullable()->index()->after('id');
        });
    }

    public function down(): void
    {
        //
    }
};
