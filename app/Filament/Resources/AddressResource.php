<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddressResource\Pages;
use App\Filament\Resources\AddressResource\RelationManagers;
use App\Models\Address;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('supplier_id')
                        ->label('Supplier')
                        ->options(Supplier::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Select::make('type')
                        ->options(['Invoice', 'Delivery', 'Other'])
                        ->required(),
                    TextInput::make('name1'),
                    TextInput::make('name2'),
                    TextInput::make('name3'),
                    TextInput::make('street'),
                    TextInput::make('street_nr'),
                    TextInput::make('city_code'),
                    TextInput::make('city'),
                    TextInput::make('country'),
                    TextInput::make('phone'),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('supplier_id')
                    ->label('Supp. ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name1')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('street')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('street_nr')
                    ->label('Nr.')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('city_code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin')
                    ->sortable(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
