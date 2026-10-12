<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('certificate_payment_configurations')) {
            return;
        }

        Schema::create('certificate_payment_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_type', 50);
            $table->string('delivery_type', 20);
            $table->decimal('price', 10, 2);

            $table->unique(['certificate_type', 'delivery_type'],'cert_payment_type_delivery_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_payment_configurations');
    }
};