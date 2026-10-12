<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultStatusId = DB::table('crm_leads_statuses')
            ->where('is_default', true)
            ->value('id');

        if (! $defaultStatusId) {
            $defaultStatusId = DB::table('crm_leads_statuses')->insertGetId([
                'name' => 'not_contacted',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('crm_leads', function (Blueprint $table) use ($defaultStatusId) {
            $table->foreignIdFor(App\Models\LeadsStatus::class, 'status_id')
                ->after('is_converted')
                ->default($defaultStatusId)
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('status_id');
        });
    }
};
