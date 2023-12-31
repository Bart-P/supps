<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers\InquiriesRelationManager;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Item;
use App\Models\Product;
use App\Models\Project;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('name')
                        ->required(),
                    Select::make('project_id')
                        ->label('Project')
                        ->searchable()
                        ->required()
                        ->options(Project::all()
                            ->map(fn ($project) => ['id' => $project->id, 'ext_id' => $project->ext_id . " | " . $project->name])
                            ->pluck('ext_id', 'id')),
                    Select::make('product_id')
                        ->searchable()
                        ->required()
                        ->label('Poduct Group')
                        ->options(Product::all()->pluck('name', 'id')),
                    Select::make('category_id')
                        ->label('Category')
                        ->searchable()
                        ->required()
                        ->options(Category::all()->pluck('name', 'id')),
                    TagsInput::make('quantities')
                        ->placeholder('new quantity'),
                    Repeater::make('descriptions')
                        ->schema([
                            Select::make('lang')
                                ->options(['DE', 'EN', 'PL'])
                                ->label('Language')
                                ->default('DE'),
                            TextInput::make('name'),
                            RichEditor::make('description')
                        ])
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('project.ext_id')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('product.name')
                    ->label('Product Group'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                SelectFilter::make('project')
                    ->relationship('project', 'ext_id')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('Attach to Inquiry')
                        ->form([
                            Select::make('inquiry')
                                ->options(
                                    Inquiry::all()
                                        ->pluck('project.ext_id', 'id')
                                        ->map(fn ($ext_id, $id) => $ext_id = "(ID: " . $id . ") - " . $ext_id)
                                )
                                ->searchable()
                                ->preload()
                        ])
                        ->action(
                            function (array $data, Collection $records) {
                                $recordIds = $records->map(fn ($record) => $record->id)->toArray();
                                Inquiry::find($data['inquiry'])->items()->syncWithoutDetaching($recordIds);
                            }
                        ),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            InquiriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
