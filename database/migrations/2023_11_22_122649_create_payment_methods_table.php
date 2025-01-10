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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name');
            $table->text('key')->nullable();
            $table->text('secret')->nullable();
            $table->string('logo')->nullable();
            $table->string('default_logo')->nullable();
            $table->integer('conversion_currency_id')->nullable();
            $table->double('conversion_currency_rate',20,2)->nullable();
            $table->integer('mode')->default(1)->comment('Sandbox=1, Live=2');
            $table->integer('status')->default(1)->comment('Active=1, Inactive=2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
