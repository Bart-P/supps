<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use App\Models\Item;
use App\Models\Project;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class InquiriesRelationManager extends RelationManager
{
    protected static string $relationship = 'inquiries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('project_id')
                    ->default($this->ownerRecord->project_id),
                Select::make('project_id')
                    ->label('Project')
                    ->searchable()
                    ->required()
                    ->options(Project::all()->pluck('ext_id', 'id')
                        ->map(fn ($ext_id, $id) => $ext_id = "(ID: " . $id . ") - " . $ext_id)),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('items')
                    ->searchable()
                    ->multiple()
                    ->options(Item::all()->pluck('name', 'id')
                        ->map(fn ($name, $id) => $name = "(ID: " . $id . ") - " . $name)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
