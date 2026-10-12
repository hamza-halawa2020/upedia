<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            if (Schema::hasColumn('sm_staffs', 'accent')) {
                $table->text('accent')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            if (Schema::hasColumn('sm_staffs', 'accent')) {
                $table->string('accent')->nullable()->change();
            }
        });
    }
};
