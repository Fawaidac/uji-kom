<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DosenResource\Pages;
use App\Filament\Resources\DosenResource\RelationManagers;
use App\Models\Dosen;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->maxLength(20)
                    // ->unique(Dosen::class, 'nip')
                    ->placeholder('Masukkan NIP'),
                TextInput::make('nama')
                    ->label('Nama Dosen')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Dosen'),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Alamat'),
                TextInput::make('no_hp')
                    ->label('No Telepon')
                    ->required()
                    ->maxLength(15)
                    ->numeric()
                    ->regex('/^[0-9]+$/')
                    ->placeholder('Masukkan No Telepon'),
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
                TextColumn::make('nip')
                    ->label('NIP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Dosen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_hp')
                    ->label('No Telepon')
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
            'index' => Pages\ListDosens::route('/'),
            'edit' => Pages\EditDosen::route('/{record}/edit'),
        ];
    }
}
