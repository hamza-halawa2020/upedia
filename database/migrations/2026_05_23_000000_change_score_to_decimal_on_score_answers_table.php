<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('score_answers', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('score_answers', function (Blueprint $table) {
            $table->tinyInteger('score')->default(0)->change();
        });
    }
};
