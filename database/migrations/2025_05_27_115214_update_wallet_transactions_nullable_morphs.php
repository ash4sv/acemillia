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
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'source_id']);
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->nullableMorphs('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'source_id']);
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->morphs('source');
        });
    }
};
