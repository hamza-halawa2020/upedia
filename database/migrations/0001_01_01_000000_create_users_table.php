<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    //0001_01_01_000000_create_users_table.php
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 192)->nullable();
            $table->string('username', 192)->nullable();
            $table->string('phone_number',191)->nullable();
            $table->string('email', 192)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('usertype', 210)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->text('random_code')->nullable();
            $table->text('notificationToken')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->string('language')->nullable()->default('en');
            $table->integer('style_id')->nullable()->default(1);
            $table->integer('rtl_ltl')->nullable()->default(2);
            $table->integer('selected_session')->nullable()->default(1);

            $table->decimal('wallet_balance', 10, 2)->nullable()->default(0.00);

            $table->integer('created_by')->nullable()->default(1);
            $table->integer('updated_by')->nullable()->default(1);
            $table->integer('access_status')->nullable()->default(1);

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            // $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->unsignedBigInteger('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->enum('is_administrator', ['yes', 'no'])->default('no');
            $table->tinyInteger('is_registered')->default(0);
            $table->text('device_token')->nullable();


            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->string('verified')->nullable();
            $table->timestamp('trial_ends_at')->nullable();




        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
