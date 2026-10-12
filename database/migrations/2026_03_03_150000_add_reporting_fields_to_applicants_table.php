<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->text('qualifications')->nullable()->after('source');
            $table->decimal('years_of_experience', 5, 2)->nullable()->after('qualifications');
            $table->date('interview_date')->nullable()->after('years_of_experience');
            $table->timestamp('offer_sent_at')->nullable()->after('offer_status');
            $table->string('offer_decline_reason')->nullable()->after('offer_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'qualifications',
                'years_of_experience',
                'interview_date',
                'offer_sent_at',
                'offer_decline_reason',
            ]);
        });
    }
};
