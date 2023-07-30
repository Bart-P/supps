<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrintTypeResource\Pages;
use App\Filament\Resources\PrintTypeResource\RelationManagers;
use App\Models\PrintType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrintTypeResource extends Resource
{
    protected static ?string $model = PrintType::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'All';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPrintTypes::route('/'),
            'create' => Pages\CreatePrintType::route('/create'),
            'edit' => Pages\EditPrintType::route('/{record}/edit'),
        ];
    }
}
