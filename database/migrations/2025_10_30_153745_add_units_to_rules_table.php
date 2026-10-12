<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('rules', function (Blueprint $table) {
            $table->enum('units', ['day', 'fixed', 'percentage'])->default('fixed')->after('value');
        });
    }

    public function down() {
        Schema::table('rules', function (Blueprint $table) {
            $table->dropColumn('units');
        });
    }
};
