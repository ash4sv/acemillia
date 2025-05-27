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
        Schema::create('wallet_withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('bank_name');
            $table->string('bank_account_name');
            $table->string('bank_account_number');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_withdraw_requests');
    }
};
