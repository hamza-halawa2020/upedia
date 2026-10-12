<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->foreignId('vendor_id')
                ->nullable()
                ->after('vendor')
                ->constrained('it_vendors')
                ->nullOnDelete();

            $table->dropColumn('vendor');
        });
    }
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('vendor')->nullable();
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
        });
    }
};