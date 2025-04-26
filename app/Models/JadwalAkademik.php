<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAkademik extends Model
{
    use HasFactory;

    protected $fillable = ['hari', 'kode_mk', 'id_ruang', 'id_gol'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_gol', 'id_gol');
    }
}
