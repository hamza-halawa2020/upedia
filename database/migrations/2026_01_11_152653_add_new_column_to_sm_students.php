<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TrackType;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->foreignIdFor(TrackType::class, 'track_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->dropForeign(['track_type_id']);
            $table->dropColumn('track_type_id');
        });
    }
};
