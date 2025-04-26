<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class Ruang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ruang';
    public $incrementing = true;
    protected $fillable = ['id_ruang', 'nama_ruang'];

    public function jadwalAkademiks()
    {
        return $this->hasMany(JadwalAkademik::class, 'id_ruang', 'id_ruang');
    }
}
