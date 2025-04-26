<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengampuResource\Pages;
use App\Filament\Resources\PengampuResource\RelationManagers;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Pengampu;
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

class PengampuResource extends Resource
{
    protected static ?string $model = Pengampu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('nip')
                    ->label('NIP Dosen')
                    ->required()
                    ->options(Dosen::all()->pluck('nama', 'nip'))
                    ->searchable()
                    ->placeholder('Pilih NIP Dosen'),
                Select::make('kode_mk')
                    ->label('Kode Mata Kuliah')
                    ->required()
                    ->options(MataKuliah::all()->pluck('nama_mk', 'kode_mk'))
                    ->searchable()
                    ->placeholder('Pilih Kode Mata Kuliah'),
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
                TextColumn::make('dosen.nip')
                    ->label('NIP Dosen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('dosen.nama')
                    ->label('Nama Dosen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mataKuliah.kode_mk')
                    ->label('Kode Mata Kuliah')
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
            'index' => Pages\ListPengampus::route('/'),
            'edit' => Pages\EditPengampu::route('/{record}/edit'),
        ];
    }
}
