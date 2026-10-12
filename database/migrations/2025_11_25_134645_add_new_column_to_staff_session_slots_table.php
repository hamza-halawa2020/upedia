<?php

use App\Models\User;
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
        Schema::table('staff_session_slots', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'scheduled_by')->after('status')->nullable();
            $table->timestamp('scheduled_at')->after('scheduled_by');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_session_slots', function (Blueprint $table) {
            $table->dropColumn('scheduled_by');
            $table->dropColumn('scheduled_at');
        });
    }
};
