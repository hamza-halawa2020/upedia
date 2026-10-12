<?php

use App\Enums\LeadActions\ActionType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('crm_leadactions', function (Blueprint $table) {
            $table->string('action')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm_leadactions', function (Blueprint $table) {
            $table->enum('action', ActionType::getAllLeadActions())->change();
        });
    }
};
