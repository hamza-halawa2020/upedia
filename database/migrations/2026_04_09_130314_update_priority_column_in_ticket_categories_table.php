<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->renameColumn('priority', 'priority_id');
        });

        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('priority_id')->nullable()->change();

            $table->foreign('priority_id')
                ->references('id')
                ->on('ticket_priorities')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->dropForeign(['priority_id']);
        });

        Schema::table('ticket_categories', function (Blueprint $table) {
            $table->renameColumn('priority_id', 'pirority');
        });
    }
};