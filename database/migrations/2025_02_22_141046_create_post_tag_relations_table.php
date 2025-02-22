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
        Schema::create('post_tag_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_tag_id')->constrained('post_tags')->onDelete('cascade');
            $table->string('model_type'); // Polymorphic type
            $table->unsignedBigInteger('model_id')->nullable(); // Polymorphic ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag_relations');
    }
};
