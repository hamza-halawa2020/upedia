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
        Schema::table('academy_products', function (Blueprint $table) {
            $table->string('count_of_students')->nullable();
            $table->enum('can_delete', ['yes', 'no'])->default('yes');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academy_products', function (Blueprint $table) {
            $table->dropColumn('can_delete');
            $table->dropColumn('count_of_students');
        });
    }
};
