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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_provider_id')->nullable()->constrained('shipping_providers')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('service_code')->nullable();
            $table->string('service_name')->nullable();
            $table->string('delivery_time')->nullable();
            $table->decimal('rate')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
