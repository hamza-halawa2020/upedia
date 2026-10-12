<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filtered_tables', function (Blueprint $table) {
            $table->id();

            $table->string('table_name');
            $table->string('model')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_url');

            $table->json('filters')->nullable();

            $table->unsignedBigInteger('total_rows')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filtered_tables');
    }
};
