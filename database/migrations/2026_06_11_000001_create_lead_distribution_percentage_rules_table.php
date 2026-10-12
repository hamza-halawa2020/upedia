<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LeadDistributionSetting;
use App\Models\Staff;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_distribution_percentage_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LeadDistributionSetting::class, 'lead_distribution_setting_id');
            $table->foreignIdFor(Staff::class, 'staff_id');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();


            $table->unique(['lead_distribution_setting_id', 'staff_id'], 'lead_distribution_setting_staff_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_distribution_percentage_rules');
    }
};
