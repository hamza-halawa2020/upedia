<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->string('lead_code')->nullable()->unique()->after('id');
        });

        DB::statement("UPDATE crm_leads SET lead_code = CONCAT('LD-', LPAD(id, 6, '0')) WHERE lead_code IS NULL");
    }

    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->dropUnique(['lead_code']);
            $table->dropColumn('lead_code');
        });
    }
};
