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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('company');
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location');
            $table->string('duration');
            $table->boolean('stipend')->default(false); // Boolean for stipend
            $table->date('deadline');
            $table->unsignedBigInteger('user_id'); // Define the user_id column
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade'); // Foreign key for company_id
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
        });

        Schema::dropIfExists('internships');
    }
};
