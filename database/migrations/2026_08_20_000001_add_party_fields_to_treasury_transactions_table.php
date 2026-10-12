<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treasury_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('treasury_transactions', 'party_type')) {
                $table->string('party_type', 50)->nullable()->after('description');
                $table->index('party_type');
            }

            if (!Schema::hasColumn('treasury_transactions', 'party_id')) {
                $table->unsignedBigInteger('party_id')->nullable()->after('party_type');
            }

            if (!Schema::hasColumn('treasury_transactions', 'party_name')) {
                $table->string('party_name')->nullable()->after('party_id');
            }

            if (!Schema::hasColumn('treasury_transactions', 'party_ref')) {
                $table->string('party_ref')->nullable()->after('party_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('treasury_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('treasury_transactions', 'party_ref')) {
                $table->dropColumn('party_ref');
            }

            if (Schema::hasColumn('treasury_transactions', 'party_name')) {
                $table->dropColumn('party_name');
            }

            if (Schema::hasColumn('treasury_transactions', 'party_id')) {
                $table->dropColumn('party_id');
            }

            if (Schema::hasColumn('treasury_transactions', 'party_type')) {
                $table->dropIndex(['party_type']);
                $table->dropColumn('party_type');
            }
        });
    }
};
