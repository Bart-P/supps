<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'name1';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options(['invoice' => 'Invoice', 'delivery' => 'Delivery', 'main' => 'Main', 'other' => 'Other'])
                    ->required(),
                TextInput::make('name1')->required(),
                TextInput::make('name2'),
                TextInput::make('name3'),
                Grid::make(2)->schema([
                    TextInput::make('street')->required(),
                    TextInput::make('street_nr')->required(),
                    TextInput::make('city_code')->required(),
                    TextInput::make('city')->required(),
                ]),
                TextInput::make('country')->required(),
                TextInput::make('phone'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->sortable(),
                TextColumn::make('name1')->searchable()->sortable(),
                TextColumn::make('street')->searchable()->sortable(),
                TextColumn::make('city')->sortable(),
                TextColumn::make('city_code')->sortable(),
                TextColumn::make('country')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
