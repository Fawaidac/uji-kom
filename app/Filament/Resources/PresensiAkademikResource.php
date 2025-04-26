<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiAkademikResource\Pages;
use App\Filament\Resources\PresensiAkademikResource\RelationManagers;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\PresensiAkademik;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresensiAkademikResource extends Resource
{
    protected static ?string $model = PresensiAkademik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Data Presensi Akademik';

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
                Select::make('nim')
                    ->label('Mahasiswa')
                    ->required()
                    ->options(
                        Mahasiswa::all()->mapWithKeys(function ($item) {
                            return [$item->nim => "{$item->nim} - {$item->nama}"];
                        })
                    )
                    ->placeholder('Pilih Mahasiswa'),
                Select::make('kode_mk')
                    ->label('Mata Kuliah')
                    ->required()
                    ->options(MataKuliah::all()->pluck('nama_mk', 'kode_mk'))
                    ->placeholder('Pilih Mata Kuliah'),
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->placeholder('Pilih Tanggal')
                    ->default(now())
                    ->displayFormat('Y-m-d'),
                Select::make('status_kehadiran')
                    ->label('Status Kehadiran')
                    ->required()
                    ->options([
                        'Hadir' => 'Hadir',
                        'Izin' => 'Izin',
                        'Alfa' => 'Alfa',
                    ])
                    ->placeholder('Pilih Status Kehadiran'),
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
                TextColumn::make('hari')
                    ->label('Hari')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.nim')
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
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status_kehadiran')
                    ->label('Status Kehadiran')
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
            'index' => Pages\ListPresensiAkademiks::route('/'),
            'edit' => Pages\EditPresensiAkademik::route('/{record}/edit'),
        ];
    }
}
