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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('type')->default(2)->comment('Bid=2, Purchase=3');
            $table->double('bid_amount',20,2)->nullable();
            $table->double('amount',10,2)->nullable();
            $table->double('tax_amount',10,2)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_address');
            $table->unsignedBigInteger('billing_country_id');
            $table->unsignedBigInteger('billing_state_id');
            $table->unsignedBigInteger('billing_city_id');
            $table->string('billing_post_code');
            $table->string('billing_phone');
            $table->string('billing_email');
            $table->string('shipping_first_name')->nullable();
            $table->string('shipping_last_name')->nullable();
            $table->string('shipping_address')->nullable();
            $table->integer('shipping_country_id')->nullable();
            $table->integer('shipping_state_id')->nullable();
            $table->integer('shipping_city_id')->nullable();
            $table->string('shipping_post_code')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_email')->nullable();
            $table->longText('message')->nullable();
            $table->integer('status')->default(1)->comment('Processing=1, Win=2, Reject=3, Completed=4, On Hold=5, Delivered=6, Refunded=7, Shipped=8');
            $table->integer('payment_status')->default(1)->comment('Partials=1, Unpaid=2, Paid=3');
            $table->integer('view')->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('billing_country_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('billing_state_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('billing_city_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
