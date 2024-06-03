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
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id_course');
            $table->integer('id_mentor')->unsigned();
            $table->foreign('id_mentor')->references('id_mentor')->on('mentor');
            $table->string('course_name', 255);
            $table->text('deskripsi');
            $table->enum('status', ['verified', 'pending', 'suspend']);
            $table->string('category', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
