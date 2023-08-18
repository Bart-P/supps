<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\EditAction;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }


    // TODO RelationManager should reload when new Category is added in form on top
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
                AttachAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
            ])
            ->actions([
                EditAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
                DeleteAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
                DetachAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
                DetachBulkAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshCategoryFields')),
            ]);
    }
}
