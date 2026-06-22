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
        Schema::table('inqueries', function (Blueprint $table) {
            $table->string('f_name')->after('name')->nullable();
            $table->string('l_name')->after('f_name')->nullable();
            $table->string('email')->after('l_name')->nullable();
            $table->string('state')->after('address')->nullable();
            $table->string('city')->after('state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inqueries', function (Blueprint $table) {
            //
        });
    }
};
