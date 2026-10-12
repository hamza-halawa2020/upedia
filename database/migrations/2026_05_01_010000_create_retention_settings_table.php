<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('retention_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default freeze invoice price
        DB::table('retention_settings')->insert([
            'key'         => 'freeze_invoice_price',
            'value'       => '10',
            'description' => 'freeze invoice price',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('retention_settings');
    }
};
