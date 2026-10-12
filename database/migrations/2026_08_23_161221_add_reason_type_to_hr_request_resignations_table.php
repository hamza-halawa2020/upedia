<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hr_request_resignations', function (Blueprint $table) {
            $table->enum('reason_type', ['voluntary', 'involuntary'])->nullable()->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table('hr_request_resignations', function (Blueprint $table) {
            $table->dropColumn('reason_type');
        });
    }
};
