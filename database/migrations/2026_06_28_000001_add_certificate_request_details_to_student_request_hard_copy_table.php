<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->string('certificate_type')->nullable();
            $table->string('certificate_name')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('country')->nullable();
            $table->string('email')->nullable();
            $table->text('request_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('student_request_hard_copy', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_type',
                'certificate_name',
                'delivery_type',
                'country',
                'email',
                'request_note',
            ]);
        });
    }
};
