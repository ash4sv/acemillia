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
            $table->foreignId('billing_address_id')->nullable()->after('user_id')->constrained('address_books')->cascadeOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->after('billing_address_id')->constrained('address_books')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_billing_address_id_foreign');
            $table->dropForeign('orders_shipping_address_id_foreign');
            $table->dropColumn('billing_address_id');
            $table->dropColumn('shipping_address_id');
        });
    }
};
