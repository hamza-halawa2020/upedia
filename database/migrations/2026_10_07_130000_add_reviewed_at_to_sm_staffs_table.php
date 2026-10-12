<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->timestamp('reviewed_at')->nullable()->after('active_status'); 
        });

        DB::table('sm_staffs')->whereNull('reviewed_at')->update(['reviewed_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('reviewed_at');
        });
    }
};
