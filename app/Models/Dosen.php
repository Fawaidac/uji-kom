<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nip', 'nama', 'alamat', 'no_hp'];

    public function pengampus()
    {
        return $this->hasMany(Pengampu::class, 'nip', 'nip');
    }
}
