<?php

namespace App\Filament\Resources\MataKuliahResource\Pages;

use App\Filament\Resources\MataKuliahResource;
use Filament\Resources\Pages\EditRecord;

class EditMataKuliah extends EditRecord
{
    protected static string $resource = MataKuliahResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
