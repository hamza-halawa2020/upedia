<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('slot_emps', function (Blueprint $table) {
            $table->string('type')->change();
        });
    }

    public function down(): void
    {
        Schema::table('slot_emps', function (Blueprint $table) {
            $table->enum('type', ['teacher', 'tester'])->change();
        });
    }
};