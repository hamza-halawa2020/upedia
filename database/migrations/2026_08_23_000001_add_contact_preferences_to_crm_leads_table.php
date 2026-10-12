<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('crm_leads', 'source')) {
            DB::statement("ALTER TABLE crm_leads MODIFY source ENUM('website', 'referral', 'ads', 'facebook', 'whatsapp', 'instagram', 'x', 'snapchat')");
        }

        Schema::table('crm_leads', function (Blueprint $table) {
            if (! Schema::hasColumn('crm_leads', 'preferred_contact_at')) {
                $table->dateTime('preferred_contact_at')->nullable()->after('next_follow_up');
            }

            if (! Schema::hasColumn('crm_leads', 'lead_location_type')) {
                $table->enum('lead_location_type', ['egypt', 'outside_egypt'])->nullable()->after('country_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            if (Schema::hasColumn('crm_leads', 'preferred_contact_at')) {
                $table->dropColumn('preferred_contact_at');
            }

            if (Schema::hasColumn('crm_leads', 'lead_location_type')) {
                $table->dropColumn('lead_location_type');
            }
        });

        if (Schema::hasColumn('crm_leads', 'source')) {
            DB::statement("ALTER TABLE crm_leads MODIFY source ENUM('website', 'referral', 'ads')");
        }
    }
};
