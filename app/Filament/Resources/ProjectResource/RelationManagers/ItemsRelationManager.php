<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Enums\InquiryLang;
use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
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
                    // Throws an error if something non numeric is tried to be saved
                    ->nestedRecursiveRules([
                        'numeric',
                        'min:1'
                    ])
                    ->columnSpanFull()
                    ->required()
                    ->placeholder('new quantity'),
                Repeater::make('descriptions')
                    ->schema([
                        Select::make('lang')
                            ->options(
                                function (Get $get, ?string $state) {
                                    // Transforming Enum to key value array for select to save / show the right data
                                    // Then filtering out what is already selected to avoid selecting a language twice

                                    $key = array_column(InquiryLang::cases(), 'name');
                                    $value = array_column(InquiryLang::cases(), 'value');
                                    $currently_selected = array_map(
                                        fn ($desc) => array_key_exists('lang', $desc) ? $desc['lang'] : null,
                                        $get('../../descriptions')
                                    );

                                    $filtered_array = array_filter(
                                        array_combine($key, $value),
                                        function ($lang) use ($currently_selected, $state) {
                                            $lower_lang = strtolower($lang);

                                            if ($lower_lang === $state)
                                                return true;

                                            return !in_array($lower_lang, $currently_selected);
                                        }
                                    );

                                    return $filtered_array;
                                }
                            )
                            ->label('Language'),
                        TextInput::make('name'),
                        RichEditor::make('description'),
                    ])
                    ->collapsible()
                    ->maxItems(count(InquiryLang::cases()))
                    ->itemLabel(fn (array $state): ?string => array_key_exists('lang', $state) ? strtoupper($state['lang']) : null)
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
                TextColumn::make('product.name')->label('Project Group'),
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
