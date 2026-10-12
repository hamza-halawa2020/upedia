<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || Schema::hasColumn('users', 'active_web_session_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('active_web_session_id')->nullable()->index()->after('remember_token');
        });
    }

    public function down(): void
    {
        //
    }
};
