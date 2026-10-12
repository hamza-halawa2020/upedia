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
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->string('id_number')->nullable();
            $table->string('other_id')->nullable();
            $table->string('religion')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('other_email')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('reporting_to')->nullable();
            $table->unsignedBigInteger('secondary_reporting_to')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->enum('source_of_hire', ['LinkedIn', 'Facebook', 'Self', 'Other'])->nullable();
            $table->string('contract')->nullable();
            $table->date('contract_renewal_date')->nullable();
            $table->date('id_expiry_date')->nullable();
            $table->string('age')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('id_number');
            $table->dropColumn('other_id');
            $table->dropColumn('religion');
            $table->dropColumn('home_phone');
            $table->dropColumn('other_email');
            $table->dropColumn('city');
            $table->dropColumn('job_title_id');
            $table->dropColumn('reporting_to');
            $table->dropColumn('secondary_reporting_to');
            $table->dropColumn('country_id');
            $table->dropColumn('source_of_hire');
            $table->dropColumn('contract');
            $table->dropColumn('contract_renewal_date');
            $table->dropColumn('age');
            $table->dropColumn('id_expiry_date');

        });
    }
};
