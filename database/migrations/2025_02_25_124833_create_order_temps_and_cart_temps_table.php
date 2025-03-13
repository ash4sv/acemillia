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
        Schema::create('order_temps', function (Blueprint $table) {
            $table->id();
            $table->enum('user', ['user', 'merchant'])->default('user');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('temporary_uniq')->nullable();
            $table->string('uniq')->nullable();
            $table->json('transaction_data')->nullable();
            $table->json('return_url_1')->nullable();
            $table->json('return_url_2')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
        });

        Schema::create('carts_temps', function (Blueprint $table) {
            $table->id();
            $table->enum('user', ['user', 'merchant'])->default('user');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('temporary_uniq')->nullable();
            $table->string('uniq')->nullable();
            $table->json('cart')->nullable();
            $table->string('discount_code')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_temps');
        Schema::dropIfExists('cart_temps');
    }
};
