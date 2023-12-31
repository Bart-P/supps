<?php

namespace App\Filament\Resources\InquiryResource\RelationManagers;

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
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    // TODO -> file uploads per Item?

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
                    ->label('Attach Item')
                    ->color('success')
                    ->form([
                        Select::make('Attach Item')
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

                        $item = Item::find($data);
                        $newItem = new Item((clone $item)->toArray());
                        $newItem->project_id = $this->ownerRecord->project_id;

                        dd($newItem);
                        Inquiry::find($this->ownerRecord->id)->items()->syncWithoutDetaching($data);
                    })
            ])
            ->actions([
                EditAction::make(),
                ReplicateAction::make()->color('success'),
                DeleteAction::make(),
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
