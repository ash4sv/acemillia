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
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->decimal('subtotal_with_commission', 15, 2)->nullable()->after('subtotal');
            $table->decimal('commission_amount', 15, 2)->nullable()->after('subtotal_with_commission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_orders', function (Blueprint $table) {
            $table->dropColumn('subtotal_with_commission');
            $table->dropColumn('commission_amount');
        });
    }
};
