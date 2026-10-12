<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->dropForeign(['ticket_category_id']);
        });

        Schema::table('ticket_items', function (Blueprint $table) {
            $table->renameColumn('ticket_category_id', 'ticket_subcategory_id');
        });

        Schema::table('ticket_items', function (Blueprint $table) {
            $table->foreign('ticket_subcategory_id')
                ->references('id')
                ->on('ticket_categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->dropForeign(['ticket_subcategory_id']);
        });

        Schema::table('ticket_items', function (Blueprint $table) {
            $table->renameColumn('ticket_subcategory_id', 'ticket_category_id');
        });

        Schema::table('ticket_items', function (Blueprint $table) {
            $table->foreign('ticket_category_id')
                ->references('id')
                ->on('ticket_categories')
                ->cascadeOnDelete();
        });
    }
};
