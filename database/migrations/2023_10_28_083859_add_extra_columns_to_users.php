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
            $table->string('phone')->after('email')->nullable();
            $table->string('company')->after('phone')->nullable();
            $table->string('country')->after('company')->nullable();
            $table->string('address')->after('country')->nullable();
            $table->string('profile_picture')->after('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('company');
            $table->dropColumn('country');
            $table->dropColumn('address');
            $table->dropColumn('profile_picture');
        });
    }
};
