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
        Schema::create('special_offers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_amount', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('promotional_text')->nullable();
            $table->string('single_image')->nullable();
            $table->json('multiple_images')->nullable();
            $table->enum('submission_type', ['vendor', 'admin'])->default('vendor');
            $table->enum('status_submission', ['pending', 'approved', 'rejected', 'archived'])->default('pending');
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
        Schema::dropIfExists('special_offers');
    }
};
