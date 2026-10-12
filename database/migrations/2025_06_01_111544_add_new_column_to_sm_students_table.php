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
        Schema::table('sm_students', function (Blueprint $table) {
            $table->string('religion')->nullable();
            $table->string('another_mobile')->nullable();
            $table->string('country_id')->nullable();
            $table->unsignedBigInteger('pricing_plan_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->dropColumn('religion');
            $table->dropColumn('another_mobile');
            $table->dropColumn('country_id');
            $table->dropColumn('pricing_plan_type_id');
        });
    }
};
