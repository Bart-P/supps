<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Item;
use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->searchable()
                    ->options(Category::all()->pluck('name', 'id')),
                Hidden::make('project_id')
                    ->default($this->ownerRecord->project_id),
                Select::make('product_id')
                    ->searchable()
                    ->required()
                    ->label('Poduct Group')
                    ->options(Product::all()->pluck('name', 'id')),
                TagsInput::make('quantities')
                    ->nestedRecursiveRules([
                        'numeric',
                        'min:1'
                    ])
                    ->placeholder('new quantity'),
                RichEditor::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('category.name'),
                TextColumn::make('product.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Action::make('item')
                    ->label('Clone Item')
                    ->color('success')
                    ->form([
                        Select::make('Item to clone')
                            ->placeholder('Select an item')
                            ->options(
                                Item::all()
                                    ->pluck('name', 'id')
                                    ->map(fn ($name, $id) => $name = "(ID: " . $id . ") - " . $name)
                            )
                            ->searchable()
                            ->preload()
                    ])
                    ->action(function (array $data) {
                        $item = Item::find($data)[0];
                        $newItem = new Item(
                            [
                                'project_id' => $this->ownerRecord->id,
                                'category_id' => $item->category_id,
                                'product_id' => $item->product_id,
                                'name' => $item->name,
                                'description' => $item->description,
                                'quantities' => $item->quantities,
                            ]
                        );

                        $newItem->save();
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ReplicateAction::make()->color('success'),
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
