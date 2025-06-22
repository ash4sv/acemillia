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
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('company_name')->nullable()->after('password');
            $table->string('company_registration_number')->nullable()->after('company_name');
            $table->string('tax_id')->nullable()->after('company_registration_number');
            $table->string('business_license_document')->nullable()->after('tax_id');
            $table->string('bank_name_account')->nullable()->after('business_license_document');
            $table->string('bank_account_details')->nullable()->after('bank_name_account');
            $table->enum('status_submission', ['pending', 'approved', 'rejected', 'archived'])->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('company_name');
            $table->dropColumn('company_registration_number');
            $table->dropColumn('tax_id');
            $table->dropColumn('business_license_document');
            $table->dropColumn('bank_name_account');
            $table->dropColumn('bank_account_details');
            $table->dropColumn('status_submission');
        });
    }
};
