<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrintTypeResource\Pages;
use App\Filament\Resources\PrintTypeResource\RelationManagers;
use App\Models\PrintType;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrintTypeResource extends Resource
{
    protected static ?string $model = PrintType::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Filter';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
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
