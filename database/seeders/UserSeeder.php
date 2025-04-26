<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        Golongan::create([
            'nama_gol' => 'Golongan A'
        ]);
        Golongan::create([
            'nama_gol' => 'Golongan B'
        ]);
        Golongan::create([
            'nama_gol' => 'Golongan C'
        ]);
        Golongan::create([
            'nama_gol' => 'Golongan D'
        ]);
        Golongan::create([
            'nama_gol' => 'Golongan E'
        ]);
        Golongan::create([
            'nama_gol' => 'Golongan F'
        ]);
    }
}
