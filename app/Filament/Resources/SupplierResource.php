<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers\AddressesRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\PeopleRelationManager;
use App\Models\Supplier;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->email()->required(),
                        TextInput::make('web')->url(),
                        CheckboxList::make('category')
                            ->relationship('categories', 'name')
                            ->columns(4)
                            ->required(),
                        CheckboxList::make('print_type')
                            ->relationship('print_types', 'name')
                            ->columns(4),
                        Select::make('tag')
                            ->relationship('tags', 'name')
                            ->preload()
                            ->multiple(),
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
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                TextColumn::make('web')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                TextColumn::make('created_at')
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->searchable()
                    ->relationship('categories', 'name'),
                SelectFilter::make('print_type')
                    ->searchable()
                    ->multiple()
                    ->relationship('print_types', 'name'),
                SelectFilter::make('tag')
                    ->searchable()
                    ->multiple()
                    ->relationship('tags', 'name'),
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
            AddressesRelationManager::class,
            PeopleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
