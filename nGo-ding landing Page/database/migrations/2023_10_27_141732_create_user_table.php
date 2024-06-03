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
        Schema::create('user', function (Blueprint $table) {
            $table->string('email', 255)->primary();
            $table->string('password', 255);
            $table->string('name', 255);
            $table->string('no_hp', 20);
            $table->string('avatar', 255);
            $table->string('tanggal_lahir',255);
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->enum('roles', ['student', 'mentor', 'admin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};

