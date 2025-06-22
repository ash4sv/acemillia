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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('remember_token');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('nationality')->nullable()->after('date_of_birth');
            $table->string('identification_number')->nullable()->after('nationality');
            $table->string('upload_documents')->nullable()->after('identification_number');
            $table->enum('status_submission', ['pending', 'approved', 'rejected', 'archived'])->default('pending')->after('upload_documents');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('nationality');
            $table->dropColumn('identification_number');
            $table->dropColumn('upload_documents');
            $table->dropColumn('phone');
            $table->dropColumn('status_submission');
        });
    }
};
