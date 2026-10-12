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
        Schema::table('promocodes', function (Blueprint $table) {
            $table->unsignedBigInteger('influencer_id')->nullable()->after('expire_date');
            $table->enum('commission_type', ['fixed', 'percentage'])->nullable()->after('influencer_id');
            $table->decimal('commission_amount', 10, 2)->nullable()->after('commission_type');

            $table->foreign('influencer_id')->references('id')->on('influencers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropForeign(['influencer_id']);
            $table->dropColumn(['influencer_id', 'commission_type', 'commission_amount']);
        });
    }
};
