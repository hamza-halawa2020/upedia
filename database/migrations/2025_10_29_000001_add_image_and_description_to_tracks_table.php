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
        Schema::table('tracks', function (Blueprint $table) {
            $table->text('description_en')->nullable()->after('name_ar');
            $table->text('description_ar')->nullable()->after('description_en');
            $table->string('image')->nullable()->after('description_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            if (Schema::hasColumn('tracks', 'description_en')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('tracks', 'description_ar')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('tracks', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};


