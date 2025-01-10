<?php

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
        Schema::create('merchant_payment_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('payment_type');
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('bank_ac_name')->nullable();
            $table->string('bank_ac_number')->nullable();
            $table->string('bank_routing_number')->nullable();
            $table->string('mobile_banking_name')->nullable();
            $table->string('mobile_banking_number')->nullable();
            $table->string('paypal_name')->nullable();
            $table->string('paypal_username')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('paypal_mobile_number')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_payment_infos');
    }
};
