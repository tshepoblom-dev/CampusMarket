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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('subject');
            $table->longText('description')->nullable();
            $table->integer('type')->default(1)->comment('New=1, Reply=2');
            $table->integer('parent_id')->default(0);
            $table->integer('department')->default(1)->comment('Technical=1, Sales=2, Billing=3, Report=4');
            $table->integer('priority')->default(1)->comment('High=1, Medium=2, Low=3');
            $table->integer('replied')->default(1)->comment('User=1, Admin=2');
            $table->integer('status')->default(1)->comment('Active=1, Closed=2');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
