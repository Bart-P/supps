<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers\AddressesRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\PeopleRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\PrintTypesRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\SupplierResource\RelationManagers\TagsRelationManager;
use App\Models\Category;
use App\Models\PrintType;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Tag;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;

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
                            ->columns(5)
                            ->required()
                            ->reactive(),
                        CheckboxList::make('print_type')
                            ->relationship('print_types', 'name')
                            ->columns(5),
                        Select::make('product')
                            ->relationship('products', 'name')
                            ->preload()
                            ->multiple(),
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
                TextColumn::make('updated_at')
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->searchable()
                    ->relationship('categories', 'name'),
                SelectFilter::make('print_type')
                    ->searchable()
                    ->multiple()
                    ->relationship('print_types', 'name'),
                SelectFilter::make('product')
                    ->searchable()
                    ->relationship('products', 'name'),
                SelectFilter::make('tag')
                    ->searchable()
                    ->multiple()
                    ->relationship('tags', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('updateCategory')
                    ->icon('heroicon-o-collection')
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->categories()->syncWithoutDetaching($data['category_id']);
                            $record->categories()->detach($data['remove_category_id']);
                            if (count($record->categories()->get()) < 1) {
                                $record->categories()->attach($data['remove_category_id'][0]);
                                Notification::make()
                                    ->title(
                                        'A Supplier has to have at least one category! Reassigned category id: '
                                            . $data['remove_category_id'][0]
                                    )
                                    ->warning()
                                    ->send();
                            }
                        });
                    })
                    ->form([
                        Select::make('category_id')
                            ->label('add Category')
                            ->options(Category::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable(),
                        Select::make('remove_category_id')
                            ->label('remove Category')
                            ->options(Category::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                    ]),
                BulkAction::make('updateTag')
                    ->icon('heroicon-o-tag')
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->tags()->syncWithoutDetaching($data['tag_id']);
                            $record->tags()->detach($data['remove_tag_id']);
                        });
                    })
                    ->form([
                        Select::make('tag_id')
                            ->options(Tag::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable(),
                        Select::make('remove_tag_id')
                            ->label('remove Tag')
                            ->options(Tag::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                    ]),
                BulkAction::make('updateProduct')
                    ->icon('heroicon-o-cube')
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->products()->syncWithoutDetaching($data['product_id']);
                            $record->products()->detach($data['remove_product_id']);
                        });
                    })
                    ->form([
                        Select::make('product_id')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->label('add Product')
                            ->multiple()
                            ->searchable(),
                        Select::make('remove_product_id')
                            ->label('remove Product')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                    ]),
                BulkAction::make('updatePrintType')
                    ->icon('heroicon-o-printer')
                    ->action(function (Collection $records, array $data): void {
                        $records->each(function ($record) use ($data) {
                            $record->print_types()->syncWithoutDetaching($data['print_type_id']);
                            $record->print_types()->detach($data['remove_print_type_id']);
                        });
                    })
                    ->form([
                        Select::make('print_type_id')
                            ->options(PrintType::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable(),
                        Select::make('remove_print_type_id')
                            ->label('remove Tag')
                            ->options(PrintType::all()->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                    ]),
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AddressesRelationManager::class,
            PeopleRelationManager::class,
            CategoriesRelationManager::class,
            PrintTypesRelationManager::class,
            ProductsRelationManager::class,
            TagsRelationManager::class,
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
