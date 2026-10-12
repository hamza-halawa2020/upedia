<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('sm_staffs', 'years_of_experience')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->unsignedSmallInteger('years_of_experience')->nullable()->after('experience');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sm_staffs', 'years_of_experience')) {
            Schema::table('sm_staffs', function (Blueprint $table) {
                $table->dropColumn('years_of_experience');
            });
        }
    }
};
