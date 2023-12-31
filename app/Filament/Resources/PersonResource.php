<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Models\Person;
use App\Models\Supplier;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('supplier_id')
                        ->options(Supplier::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Select::make('type')
                        ->options(['main' => 'Main', 'backup' => 'Backup', 'other' => 'Other'])
                        ->required(),
                    Select::make('gender')
                        ->options(['m' => 'Male', 'f' => 'Female', 'o' => 'Other'])
                        ->required(),
                    TextInput::make('first_name')
                        ->required(),
                    TextInput::make('last_name')
                        ->required(),
                    TextInput::make('position'),
                    TextInput::make('phone1'),
                    TextInput::make('phone2'),
                    TextInput::make('email1'),
                    TextInput::make('email2'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->grow(false)
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->copyable()
                    ->limit(17)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->formatStateUsing(fn (string $state): string => __("{$state}")[0])
                    ->grow(false)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('first_name')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_name')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email1')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone1')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
