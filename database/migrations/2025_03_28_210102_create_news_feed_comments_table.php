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
        Schema::create('newsfeed_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsfeed_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->text('comment');
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('newsfeed_id')->references('id')->on('newsfeeds')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('newsfeed_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsfeed_comments');
    }
};
