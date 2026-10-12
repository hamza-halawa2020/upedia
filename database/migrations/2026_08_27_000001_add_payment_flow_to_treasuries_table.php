<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('treasuries', 'payment_flow')) {
            return;
        }

        Schema::table('treasuries', function (Blueprint $table) {
            $table->string('payment_flow')->default('manual')->after('type');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('treasuries', 'payment_flow')) {
            return;
        }

        Schema::table('treasuries', function (Blueprint $table) {
            $table->dropColumn('payment_flow');
        });
    }
};
