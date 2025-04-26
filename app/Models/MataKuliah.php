<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester'];

    public function presensiAkademiks()
    {
        return $this->hasMany(PresensiAkademik::class, 'kode_mk', 'kode_mk');
    }

    public function jadwalAkademiks()
    {
        return $this->hasMany(JadwalAkademik::class, 'kode_mk', 'kode_mk');
    }

    public function pengampus()
    {
        return $this->hasMany(Pengampu::class, 'kode_mk', 'kode_mk');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'kode_mk', 'kode_mk');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_mk)) {
                $lastKode = MataKuliah::latest('kode_mk')->first();
                $lastKodeNumber = 1;

                if ($lastKode) {
                    $lastKodeNumber = (int) substr($lastKode->kode_mk, 2) + 1;
                }

                $model->kode_mk = 'MK' . str_pad($lastKodeNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
