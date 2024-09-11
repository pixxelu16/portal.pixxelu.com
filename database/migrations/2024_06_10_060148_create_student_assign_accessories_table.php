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
        Schema::create('student_assign_accessories', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->nullable(); 
            $table->string('assign_accessories_name')->nullable(); 
            $table->string('assign_accessories_date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assign_accessories');
    }
};
