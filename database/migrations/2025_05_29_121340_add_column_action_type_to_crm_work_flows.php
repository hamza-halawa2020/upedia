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
        Schema::table('crm_work_flows', function (Blueprint $table) {
            $table->string('action_type')->nullable()->after('type')->comment('Type of action for the workflow, e.g., reschedule_call, select_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_work_flows', function (Blueprint $table) {
            $table->dropColumn('action_type');
        });
    }
};
