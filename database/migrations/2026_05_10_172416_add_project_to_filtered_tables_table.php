<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('filtered_tables', function (Blueprint $table) {
            $table->string('project')
                ->nullable()
                ->after('table_name');
        });
    }

    public function down()
    {
        Schema::table('filtered_tables', function (Blueprint $table) {
            $table->dropColumn('project');
        });
    }
};
