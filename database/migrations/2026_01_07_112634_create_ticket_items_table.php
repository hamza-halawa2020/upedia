<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('ticket_category_id');
            $table->foreign('ticket_category_id')
                ->references('id')
                ->on('ticket_categories')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ticket_items');
    }
};
