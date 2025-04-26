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
        Schema::create('jadwal_akademiks', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->string('kode_mk');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            $table->unsignedBigInteger('id_ruang');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruangs')->onDelete('cascade');
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
        Schema::dropIfExists('jadwal_akademiks');
    }
};
