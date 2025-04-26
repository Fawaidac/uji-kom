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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim')->unique()->primary();
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_telepon');
            $table->enum('semester', ['1', '2', '3', '4', '5', '6', '7', '8']);
            $table->unsignedBigInteger('id_gol');
            $table->foreign('id_gol')->references('id_gol')->on('golongans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
