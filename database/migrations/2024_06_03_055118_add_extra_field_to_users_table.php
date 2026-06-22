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
            $table->string('unique_employee_id')->after('id')->nullable();
            $table->string('pin_code')->after('state')->nullable();
            $table->string('batch_timing')->after('course_joining_date')->nullable();
            $table->string('national_id')->after('resign_date')->nullable();
            $table->string('blood')->after('national_id')->nullable();
            $table->string('religion')->after('blood')->nullable();
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
