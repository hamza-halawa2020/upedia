<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_emp_id')->nullable()->after('manager_id');
            $table->foreign('shift_emp_id')->references('id')->on('shift_emps')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropForeign(['shift_emp_id']);
            $table->dropColumn('shift_emp_id');
        });
    }
};
