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
            $table->string('employee_phone_no')->after('total_fees')->nullable();
            $table->string('joining_date')->after('employee_phone_no')->nullable();
            $table->string('resign_date')->after('joining_date')->nullable();
            $table->string('experince')->after('resign_date')->nullable();
            $table->string('net_salary')->after('experince')->nullable();
            $table->string('employee_role')->after('net_salary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
