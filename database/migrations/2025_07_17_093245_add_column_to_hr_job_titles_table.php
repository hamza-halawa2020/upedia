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
        Schema::table('hr_job_titles', function (Blueprint $table) {
            $table->string('slug')->after('department_id')->nullable();
            $table->enum('can_delete', ['yes', 'no'])->after('slug')->default('yes');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_job_titles', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('can_delete');
        });
    }
};
