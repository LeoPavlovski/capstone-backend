<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('internship_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('internship_id')->references('id')->on('internships')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('internship_student');
    }
};
