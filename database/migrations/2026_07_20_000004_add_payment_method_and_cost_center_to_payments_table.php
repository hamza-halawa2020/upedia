<?php

use App\Models\CostCenter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method', 30)->default('cash')->after('currency');
            $table->foreignIdFor(CostCenter::class)->nullable()->after('payment_method')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['cost_center_id']);
            $table->dropColumn(['payment_method', 'cost_center_id']);
        });
    }
};
