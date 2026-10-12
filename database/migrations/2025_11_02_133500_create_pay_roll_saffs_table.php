<?php

use App\Models\PayrollRun;
use App\Models\Staff;
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
        Schema::create('pay_roll_saffs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PayrollRun::class);
            $table->foreignIdFor(Staff::class);
            $table->decimal('gross_salary', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->decimal('penalties', 12, 2)->default(0);
            $table->decimal('bonuses', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['payroll_run_id', 'staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_roll_saffs');
    }
};
