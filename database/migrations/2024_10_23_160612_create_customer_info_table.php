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
        Schema::create('customer_info', function (Blueprint $table) {
              $table->id();
              $table->string('transaction_guid')->nullable();
              // Billing Information
              $table->string('billing_first_name')->nullable();
              $table->string('billing_last_name')->nullable();
              $table->text('billing_address')->nullable();
              $table->unsignedBigInteger('billing_country_id')->nullable();
              $table->unsignedBigInteger('billing_state_id')->nullable();
              $table->unsignedBigInteger('billing_city_id')->nullable();
              $table->string('billing_post_code')->nullable();
              $table->string('billing_phone')->nullable();
              $table->string('billing_email')->nullable();

              // Shipping Information
              $table->string('shipping_first_name')->nullable();
              $table->string('shipping_last_name')->nullable();
              $table->text('shipping_address')->nullable();
              $table->unsignedBigInteger('shipping_country_id')->nullable();
              $table->unsignedBigInteger('shipping_state_id')->nullable();
              $table->unsignedBigInteger('shipping_city_id')->nullable();
              $table->string('shipping_post_code')->nullable();
              $table->string('shipping_phone')->nullable();
              $table->string('shipping_email')->nullable();

              // Additional Information
              $table->text('message')->nullable();
              $table->unsignedBigInteger('product_id')->nullable();
              $table->unsignedBigInteger('merchant_id')->nullable();
              $table->decimal('bid_amount', 10, 2)->default(0);
              $table->decimal('amount', 10, 2)->default(0);
              $table->decimal('tax_amount', 10, 2)->default(0);
              $table->decimal('total_amount', 10, 2)->default(0);
              $table->integer('type')->default(1);
              $table->string('currency')->default('ZAR');
              $table->string('current_url')->nullable();
              $table->integer('quantity')->default(1);
              $table->string('order_id')->nullable();

              // Timestamps
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_info');
    }
};
