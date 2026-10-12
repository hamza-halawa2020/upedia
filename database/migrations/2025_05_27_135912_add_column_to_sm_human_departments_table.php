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
        Schema::table('sm_human_departments', function (Blueprint $table) {
            $table->string('mail_alias')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('department_head_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_human_departments', function (Blueprint $table) {
            $table->dropColumn('mail_alias');
            $table->dropColumn('parent_id');
            $table->dropColumn('department_head_id');
        });
    }
};
