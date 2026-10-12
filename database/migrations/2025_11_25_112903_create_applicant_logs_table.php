<?php

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('applicant_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Applicant::class,'applicant_id');
            $table->foreignIdFor(User::class,'changed_by');
            $table->string('field');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_logs');
    }
};
