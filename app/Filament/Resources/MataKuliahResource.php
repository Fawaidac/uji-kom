<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataKuliahResource\Pages;
use App\Filament\Resources\MataKuliahResource\RelationManagers;
use App\Models\MataKuliah;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MataKuliahResource extends Resource
{
    protected static ?string $model = MataKuliah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Data Mata Kuliah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_mk')
                    ->label('Nama Mata Kuliah')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Mata Kuliah'),

                TextInput::make('sks')
                    ->label('Jumlah SKS')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(20)
                    ->maxLength(2)
                    ->placeholder('Masukkan Jumlah SKS'),

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
                TextColumn::make('kode_mk')
                    ->label('Kode Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama_mk')
                    ->label('Nama Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sks')
                    ->label('Jumlah SKS')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('semester')
                    ->label('Semester')
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
            'index' => Pages\ListMataKuliahs::route('/'),
            'edit' => Pages\EditMataKuliah::route('/{record}/edit'),
        ];
    }
}
