<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $mahasiswa = static::getModel()::create($data);

        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['nim'] . '@gmail.com',
            'nim' => $data['nim'],
            'password' => Hash::make('12345678'),
        ]);

        // dd($user);
        return $mahasiswa;
    }
}
