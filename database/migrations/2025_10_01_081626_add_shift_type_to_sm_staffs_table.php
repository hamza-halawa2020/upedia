<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->enum('shift_type', ['morning', 'night'])->default('morning');
        });
    }

    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('shift_type');
        });
    }
};
