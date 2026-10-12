<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('email');
        });
    }
    public function down(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->dropColumn('occupation');
        });
    }
};
