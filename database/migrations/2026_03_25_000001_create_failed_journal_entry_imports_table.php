<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('failed_journal_entry_imports', function (Blueprint $table) {
            $table->id();
            $table->string('source_system', 100)->nullable()->index();
            $table->string('external_reference', 100)->nullable()->index();
            $table->json('payload')->nullable();
            $table->text('error_message');
            $table->string('error_class', 255)->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_journal_entry_imports');
    }
};

