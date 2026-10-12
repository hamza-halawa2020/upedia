<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('retention_feedback', function (Blueprint $table) {
        $table->string('minutes_delayed')->nullable()->after('delay_in_start');
    });
}
    public function down()
{
    Schema::table('retention_feedback', function (Blueprint $table) {
        $table->dropColumn('minutes_delayed');
    });
}
};
