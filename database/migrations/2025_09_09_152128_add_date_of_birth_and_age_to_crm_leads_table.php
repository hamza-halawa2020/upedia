<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('nationality_id');
            $table->integer('age')->nullable()->after('date_of_birth');
        });
    }
    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'age']);
        });
    }
};
