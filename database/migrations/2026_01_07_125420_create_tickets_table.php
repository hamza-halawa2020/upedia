<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('ticket_category_id')->nullable();
            $table->unsignedBigInteger('ticket_subcategory_id')->nullable();
            $table->unsignedBigInteger('ticket_item_id')->nullable();
            $table->unsignedBigInteger('created_by');

            $table->enum('request_type', ['issue', 'request', 'inquiry']);
            $table->enum('priority', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->timestamps();
            $table->foreign('ticket_category_id')->references('id')->on('ticket_categories')->nullOnDelete();
            $table->foreign('ticket_subcategory_id')->references('id')->on('ticket_categories')->nullOnDelete();
            $table->foreign('ticket_item_id')->references('id')->on('ticket_items')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
