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
                    ->multiple()
                    ->required()
                    ->options(Project::all()
                        ->map(fn ($project) => ['id' => $project->id, 'ext_id' => $project->ext_id . " | " . $project->name])
                        ->pluck('ext_id', 'id')),
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
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
