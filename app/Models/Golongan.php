<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_gol';

    protected $fillable = ['id_gol', 'nama_gol'];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'id_gol', 'id_gol');
    }

    public function jadwalAkademiks()
    {
        return $this->hasMany(JadwalAkademik::class, 'id_gol', 'id_gol');
    }
}
