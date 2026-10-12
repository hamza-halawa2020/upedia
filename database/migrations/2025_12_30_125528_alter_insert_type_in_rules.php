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
        Schema::table('rules', function (Blueprint $table) {
            Schema::dropColumns('rules', 'insert_type');
            $table->enum('insert_type', ['manual', 'auto'])->default('manual');
        });

        Rule::limit(10)->update(['insert_type' => 'auto' ,  'status' => 'active' , 'units' =>  'day']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rules', function (Blueprint $table) {
            //
        });
    }
};
