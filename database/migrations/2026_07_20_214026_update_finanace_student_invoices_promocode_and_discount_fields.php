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
            // Rename existing columns
            $table->renameColumn('discount_type', 'promocode_type');
            $table->renameColumn('discount', 'promocode_price');

            // Add new columns
            $table->unsignedBigInteger('discount_plan_id')->nullable()->after('promocode_price');
            $table->enum('discount_plan_type', ['fixed', 'percentage'])->nullable()->after('discount_plan_id');
            $table->decimal('discount_plan_price', 10, 2)->nullable()->after('discount_plan_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            // Rollback rename
            $table->renameColumn('promocode_type', 'discount_type');
            $table->renameColumn('promocode_price', 'discount');

            // Drop added columns
            $table->dropColumn(['discount_plan_id', 'discount_plan_type', 'discount_plan_price']);
        });
    }
};
