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
        Schema::create('newsfeed_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsfeed_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('newsfeed_id')->references('id')->on('newsfeeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsfeed_likes');
    }
};
