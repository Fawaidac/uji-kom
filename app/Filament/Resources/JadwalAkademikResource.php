<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalAkademikResource\Pages;
use App\Filament\Resources\JadwalAkademikResource\RelationManagers;
use App\Models\Golongan;
use App\Models\JadwalAkademik;
use App\Models\MataKuliah;
use App\Models\Ruang;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalAkademikResource extends Resource
{
    protected static ?string $model = JadwalAkademik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('hari')
                    ->label('Hari')
                    ->required()
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                    ])
                    ->placeholder('Pilih Hari'),
                Select::make('kode_mk')
                    ->label('Mata Kuliah')
                    ->required()
                    ->options(MataKuliah::all()->pluck('nama_mk', 'kode_mk'))
                    ->placeholder('Pilih Mata Kuliah'),
                Select::make('id_ruang')
                    ->label('Nama Ruang')
                    ->required()
                    ->options(Ruang::all()->pluck('nama_ruang', 'id_ruang'))
                    ->placeholder('Pilih Ruangan'),
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
                    ->state(
                        static function ($record, $livewire) {
                            $perPage = $livewire->getTableRecordsPerPage();
                            $page = $livewire->getTablePage();
                            $index = $livewire->getTableRecords()->search(fn($item) => $item->getKey() === $record->getKey());
                            return ($page - 1) * $perPage + $index + 1;
                        }
                    ),
                TextColumn::make('hari')
                    ->label('Hari')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mataKuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ruang.nama_ruang')
                    ->label('Nama Ruang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('golongan.nama_gol')
                    ->label('Golongan')
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
            'index' => Pages\ListJadwalAkademiks::route('/'),
            'edit' => Pages\EditJadwalAkademik::route('/{record}/edit'),
        ];
    }
}
