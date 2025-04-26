<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Golongan;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Data Mahasiswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nim')
                    ->label('NIM')
                    ->required()
                    ->maxLength(9)
                    // ->unique(Mahasiswa::class, 'nim')
                    ->placeholder('Masukkan NIM'),

                TextInput::make('nama')
                    ->label('Nama Mahasiswa')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Mahasiswa'),

                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Alamat'),

                TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->required()
                    ->maxLength(15)
                    ->numeric()
                    ->regex('/^[0-9]+$/')
                    ->placeholder('Masukkan No Telepon'),

                Select::make('semester')
                    ->label('Semester')
                    ->required()
                    ->options([
                        '1' => 'Semester 1',
                        '2' => 'Semester 2',
                        '3' => 'Semester 3',
                        '4' => 'Semester 4',
                        '5' => 'Semester 5',
                        '6' => 'Semester 6',
                        '7' => 'Semester 7',
                        '8' => 'Semester 8',
                    ])
                    ->placeholder('Pilih Semester'),

                Select::make('id_gol')
                    ->label('Golongan')
                    ->required()
                    ->options(Golongan::all()->pluck('nama_gol', 'id_gol'))
                    ->placeholder('Pilih Golongan'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->label('No')
                    ->sortable()
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
                TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_telepon')
                    ->label('No Telepon')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('golongan.nama_gol')
                    ->label('Golongan')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->golongan ? $record->golongan->nama_gol : '-';
                    }),
            ])
            ->filters([])
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
            'index' => Pages\ListMahasiswas::route('/'),
            // 'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
