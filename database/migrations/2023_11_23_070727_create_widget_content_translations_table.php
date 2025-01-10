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
        Schema::create('widget_content_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('widget_content_id');
            $table->unsignedBigInteger('page_id');
            $table->text('widget_content')->nullable();
            $table->string('lang');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('widget_content_id')->references('id')->on('widget_contents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_content_translations');
    }
};
