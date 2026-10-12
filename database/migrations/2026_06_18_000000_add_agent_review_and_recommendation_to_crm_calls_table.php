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
        Schema::table('crm_calls', function (Blueprint $table) {
            $table->unsignedTinyInteger('agent_review')->nullable()->after('notes');
            $table->string('recommendation_name')->nullable()->after('agent_review');
            $table->string('recommendation_email')->nullable()->after('recommendation_name');
            $table->string('recommendation_phone')->nullable()->after('recommendation_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_calls', function (Blueprint $table) {
            $table->dropColumn([
                'agent_review',
                'recommendation_name',
                'recommendation_email',
                'recommendation_phone',
            ]);
        });
    }
};
