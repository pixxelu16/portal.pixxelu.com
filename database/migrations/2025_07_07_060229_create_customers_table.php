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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();  
            $table->string('email')->nullable();
            $table->string('dob')->nullable();  
            $table->string('father_name')->nullable();  
            $table->string('national_id')->nullable();
            $table->string('mobile')->nullable();  
            $table->string('gender')->nullable();  
            $table->string('joining_date')->nullable();  
            $table->string('education')->nullable();  
            $table->string('blood')->nullable();  
            $table->string('religion')->nullable();
            $table->string('experience')->nullable();
            $table->string('home_address')->nullable();
            $table->string('monthly_salary')->nullable();
            $table->string('employee_role')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['Active','Pending','Suspend','Approved'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
