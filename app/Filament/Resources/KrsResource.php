<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KrsResource\Pages;
use App\Filament\Resources\KrsResource\RelationManagers;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KrsResource extends Resource
{
    protected static ?string $model = Krs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('nim')
                    ->label('NIM')
                    ->required()
                    ->options(Mahasiswa::all()->pluck('nim', 'nim'))
                    ->searchable()
                    ->placeholder('Pilih NIM Mahasiswa'),
                Select::make('kode_mk')
                    ->label('Mata Kuliah')
                    ->required()
                    ->multiple()
                    ->options(MataKuliah::all()->pluck('nama_mk', 'kode_mk'))
                    ->placeholder('Pilih Mata Kuliah'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->label('No')
                    ->state(
                        static function ($record, $livewire) {
                            $perPage = $livewire->getTableRecordsPerPage();
                            $page = $livewire->getTablePage();
                            $index = $livewire->getTableRecords()->search(fn($item) => $item->getKey() === $record->getKey());
                            return ($page - 1) * $perPage + $index + 1;
                        }
                    ),
                TextColumn::make('nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mataKuliah.nama_mk')
                    ->label('Nama Mata Kuliah')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKrs::route('/'),
            'edit' => Pages\EditKrs::route('/{record}/edit'),
        ];
    }
}
