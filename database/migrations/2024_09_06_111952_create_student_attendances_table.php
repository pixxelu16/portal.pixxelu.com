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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('batch ')->nullable();
            $table->string('batch_time')->nullable();
            $table->string('punch_in_time')->nullable();
            $table->string('punch_out_time')->nullable();
            $table->string('submission_date')->nullable();
            $table->string('attendance_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
