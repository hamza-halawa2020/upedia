<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('journal_entries', 'party_name')) {
                $table->string('party_name')->nullable()->after('description');
            }

            if (!Schema::hasColumn('journal_entries', 'party_type')) {
                $table->string('party_type')->nullable()->after('party_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            if (Schema::hasColumn('journal_entries', 'party_type')) {
                $table->dropColumn('party_type');
            }

            if (Schema::hasColumn('journal_entries', 'party_name')) {
                $table->dropColumn('party_name');
            }
        });
    }
};
