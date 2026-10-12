<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treasury_account_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treasury_id')->constrained('treasuries')->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('chart_of_accounts')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['treasury_id', 'account_id'], 'treasury_account_links_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treasury_account_links');
    }
};
