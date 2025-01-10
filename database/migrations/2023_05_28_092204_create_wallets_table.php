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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('order_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_email')->nullable();
            $table->integer('type')->default(1)->comment('Deposit=1, Bid=2, Purchase=3, Withdraw=4, Return=5, Refund=6, Bid Final Payment=7');
            $table->double('amount',10,2)->nullable();
            $table->integer('admin_commission_rate')->nullable();
            $table->double('admin_commission',10,2)->nullable();
            $table->double('merchant_amount',10,2)->nullable();
            $table->double('tax_amount',10,2)->nullable();
            $table->double('total_amount',10,2)->nullable();
            $table->string('payment_method')->nullable();
            $table->text('transaction_id')->nullable();
            $table->string('currency')->nullable();
            $table->double('gateway_amount',10,2)->nullable();
            $table->text('payment_details')->nullable();
            $table->integer('status')->default(1)->comment('Processing=1, Completed=2, Cancel=3');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
