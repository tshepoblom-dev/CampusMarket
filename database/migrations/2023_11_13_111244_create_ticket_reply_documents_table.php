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
        Schema::create('ticket_reply_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_reply_id');
            $table->string('document');
            $table->timestamps();
            $table->foreign('ticket_reply_id')->references('id')->on('ticket_replies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_reply_documents');
    }
};
