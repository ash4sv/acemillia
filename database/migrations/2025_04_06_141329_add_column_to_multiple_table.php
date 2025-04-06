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
            $table->string('icon_avatar')->after('id')->nullable();
            $table->string('img_avatar')->after('icon_avatar')->nullable();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->string('icon_avatar')->after('id')->nullable();
            $table->string('img_avatar')->after('icon_avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('icon_avatar');
            $table->dropColumn('img_avatar');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('icon_avatar');
            $table->dropColumn('img_avatar');
        });
    }
};
