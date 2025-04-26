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
        Schema::create('presensi_akademiks', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->string('kode_mk');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Alfa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_akademiks');
    }
};
