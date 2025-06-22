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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', [
                'SALE', 'REFUND', 'WITHDRAW', 'MANUAL_CREDIT', 'MANUAL_DEBIT'
            ]);
            $table->decimal('amount', 15, 2);
            $table->text('remarks')->nullable();
            $table->morphs('source');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
