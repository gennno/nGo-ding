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
        Schema::create('course_material', function (Blueprint $table) {
            $table->increments('id_material');
            $table->integer('id_course')->unsigned();
            $table->foreign('id_course')->references('id_course')->on('course');
            $table->enum('status', ['verified', 'pending', 'suspend']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_material');
    }
};
