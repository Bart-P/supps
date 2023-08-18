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
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
                AttachAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
            ])
            ->actions([
                EditAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
                DeleteAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
                DetachAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
                DetachBulkAction::make()
                    ->after(fn ($livewire) => $livewire->emit('refreshFields')),
            ]);
    }
}
