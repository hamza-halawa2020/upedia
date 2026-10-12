<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration
{
    public function up()
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->enum('status', ['pending', 'rejected', 'accepted'])
                  ->default('pending')
                  ->after('staff_scheduled_id');
        });
    }
    public function down()
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
