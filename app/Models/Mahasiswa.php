<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';
    public $incrementing = false;

    protected $fillable = ['nim', 'nama', 'alamat', 'no_telepon', 'semester', 'id_gol'];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_gol', 'id_gol');
    }

    public function presensiAkademiks()
    {
        return $this->hasMany(PresensiAkademik::class, 'nim', 'nim');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'nim', 'nim');
    }
}
