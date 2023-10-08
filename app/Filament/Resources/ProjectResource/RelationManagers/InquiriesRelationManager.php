<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Item;
use App\Models\Project;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
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
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('items')
                    ->relationship('items', 'id')
                    ->searchable()
                    ->multiple()
                    ->options(Project::find($this->ownerRecord->id)
                        ->items()
                        ->pluck('name', 'id')
                        ->map(fn ($name, $id) => $name = "(ID: " . $id . ") - " . $name)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ReplicateAction::make()
                    ->color('success'),
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
