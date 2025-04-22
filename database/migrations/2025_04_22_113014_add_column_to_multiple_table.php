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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('uniq')->unique();
        });

        Schema::table('carts_temps', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('uniq')->unique();
        });

        Schema::table('order_temps', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('uniq')->unique();
        });

        Schema::create('cart_cleanup_queue', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->json('item_ids')->nullable();
            $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });

        Schema::table('carts_temps', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });

        Schema::table('order_temps', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });

        Schema::dropIfExists('cart_cleanup_queue');
    }
};
