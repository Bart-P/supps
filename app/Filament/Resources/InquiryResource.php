<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers\ItemsRelationManager;
use App\Models\Inquiry;
use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Data';

    public static function getEloquentQuery(): Builder
    {
        // TODO - join throughs an error, why?
        // Select does not seem to help...
        return parent::getEloquentQuery()
            ->join('projects', 'inquiries.project_id', '=', 'projects.id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->searchable()
                    ->options(Project::all()->pluck('ext_id', 'id')),
                TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_id'),
                TextColumn::make('name'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
