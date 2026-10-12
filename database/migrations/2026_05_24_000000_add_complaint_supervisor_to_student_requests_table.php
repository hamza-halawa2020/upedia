<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->boolean('is_complain')->default(false)->after('request_type_id');
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('is_complain');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on('sm_staffs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_requests', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn(['is_complain', 'supervisor_id']);
        });
    }
};
