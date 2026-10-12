<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('journal_entries', 'party_id')) {
                $table->unsignedBigInteger('party_id')->nullable()->after('party_type');
            }

            if (!Schema::hasColumn('journal_entries', 'party_ref')) {
                $table->string('party_ref')->nullable()->after('party_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            if (Schema::hasColumn('journal_entries', 'party_ref')) {
                $table->dropColumn('party_ref');
            }

            if (Schema::hasColumn('journal_entries', 'party_id')) {
                $table->dropColumn('party_id');
            }
        });
    }
};
