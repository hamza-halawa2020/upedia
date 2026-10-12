<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up()
    {
        Schema::table('complains', function (Blueprint $table) {
            // 1. Add column nullable, correct type
            $table->unsignedBigInteger('staff_id')->nullable()->after('id');

            // 2. Drop the old column
            $table->dropColumn('sales');
        });
    }
    public function down()
    {
        Schema::table('complains', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
            $table->string('sales');
        });
    }
};
