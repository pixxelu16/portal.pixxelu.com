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
            $table->string('first_name')->after('remember_token')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->date('dob')->after('last_name')->nullable();
            $table->string('gender')->after('dob')->nullable();
            $table->string('father_name')->after('gender')->nullable();
            $table->string('father_phone_no')->after('father_name')->nullable();
            $table->string('aadhaar_no')->after('father_phone_no')->nullable();
            $table->string('student_phone_no')->after('aadhaar_no')->nullable();
            $table->string('marital_status')->after('student_phone_no')->nullable();
            $table->string('category')->after('marital_status')->nullable();
            $table->string('address')->after('category')->nullable();
            $table->string('district')->after('address')->nullable();
            $table->string('state')->after('district')->nullable();
            $table->string('qualification')->after('state')->nullable();
            $table->string('course_type')->after('qualification')->nullable();
            $table->string('course_duration')->after('course_type')->nullable();
            $table->date('course_joining_date')->after('course_duration')->nullable();
            $table->date('course_complession_date')->after('course_joining_date')->nullable();
            $table->string('total_fees')->after('course_complession_date')->nullable();
            $table->string('user_pic')->after('total_fees')->nullable();
            $table->enum('user_status', ['Active','Pending','Suspend','Completed','Leave'])->default('Active')->after('user_pic')->nullable();
            $table->enum('user_type', ['Super_Admin','Admin','Student','Employee','Subscriber'])->default('Admin')->after('user_status')->nullable();    
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
