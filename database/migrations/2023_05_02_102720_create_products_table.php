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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumText('slug');
            $table->string('sku')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_keyward')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->text('short_desc')->nullable();
            $table->longText('long_desc')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->text('features_image')->nullable();
            $table->integer('sale_type')->default(1)->comment('Action=1, Direct=2');
            $table->integer('schedule_type')->default(1)->comment('Yes=1, No=2');
            $table->string('min_deposit')->nullable();
            $table->integer('min_deposit_type')->default(1)->comment('Percent=1, Fixed=2');
            $table->integer('quantity')->default(1);
            $table->double('price', 10, 2)->nullable();
            $table->double('sale_price', 10, 2)->nullable();
            $table->double('min_bid_price', 10, 2)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('status')->default(1)->comment('Published=1, Draft=2, Pending=3, Inactive=4');
            $table->string('enable_seo')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
