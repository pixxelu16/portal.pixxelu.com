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
        Schema::create('inqueries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('course_type')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('desc')->nullable();
            $table->enum('status', ['Active','Closed','Converted','Office_Visited'])->default('Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inqueries');
    }
};
