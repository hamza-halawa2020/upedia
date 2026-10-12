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
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('referral_activity_id')->nullable()->after('discount_plan_price');
            $table->enum('referral_activity_type', ['fixed', 'percentage'])->nullable()->after('referral_activity_id');
            $table->decimal('referral_activity_price', 10, 2)->nullable()->after('referral_activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropColumn(['referral_activity_id', 'referral_activity_type', 'referral_activity_price']);
        });
    }
};
