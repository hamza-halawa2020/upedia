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
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_plan_id')->nullable();
            // $table->foreign('discount_plan_id')->references('id')->on('discount_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('track_pricing_plans', function (Blueprint $table) {
            $table->dropForeign(['discount_plan_id']);
            $table->dropColumn('discount_plan_id');
        });
    }
};
