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
        Schema::create('shipping_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_order_id')->nullable()->constrained('sub_orders')->cascadeOnDelete();
            $table->enum('status', ['pending', 'processing', 'packed', 'shipped', 'delivered', 'cancelled', 'returned'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('merchants')->cascadeOnDelete(); // FK to users table — who performed the action (merchant or admin)
            $table->timestamp('log_created_at')->nullable(); // Timestamp of the status update
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->nullable();
            $table->date('expected_delivery')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_status_logs');
    }
};
