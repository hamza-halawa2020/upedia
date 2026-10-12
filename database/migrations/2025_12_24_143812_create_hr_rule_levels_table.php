<?php

use App\Models\Rule;
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
        Schema::create('hr_rule_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rule::class, 'hr_rule_id')->constrained('rules')->onDelete('cascade');
            $table->unsignedBigInteger('level_number')->default(1);
            $table->enum('penalty_type', ['warning', 'money', 'days', 'points', 'termination']);
            $table->decimal('penalty_value', 10, 2)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('hr_rule_id');
            $table->index(['hr_rule_id', 'level_number']);
            $table->unique(['hr_rule_id', 'level_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_rule_levels');
    }
};
