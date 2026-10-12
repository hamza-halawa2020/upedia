<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('track_type_id')->nullable()->after('levels_count');

            $table->foreign('track_type_id')
                ->references('id')->on('track_types')
                ->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('finanace_student_invoices', function (Blueprint $table) {
            $table->dropForeign(['track_type_id']);
            $table->dropColumn('track_type_id');
        });
    }
};
