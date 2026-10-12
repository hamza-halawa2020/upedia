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
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->string('instagram_page_id')->nullable();
            $table->text('instagram_page_access_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_settings', function (Blueprint $table) {
            $table->dropColumn(['instagram_page_id', 'instagram_page_access_token']);
        });
    }
};
