<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GolonganResource\Pages;
use App\Filament\Resources\GolonganResource\RelationManagers;
use App\Models\Golongan;
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

class GolonganResource extends Resource
{
    protected static ?string $model = Golongan::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Data Golongan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_gol')
                    ->label('Nama Golongan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Golongan')
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
                TextColumn::make('nama_gol')
                    ->label('Nama Golongan')
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
            'index' => Pages\ListGolongans::route('/'),
            'edit' => Pages\EditGolongan::route('/{record}/edit'),
        ];
    }
}
