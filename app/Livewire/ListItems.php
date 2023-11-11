<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Models\Item;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListItems extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public int $inquiry_id;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn () => Inquiry::find($this->inquiry_id)->items())
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name'),
                TextColumn::make('product.name'),
                TextColumn::make('updated_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                TextColumn::make('created_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
            ])
            ->headerActions([
                // ...
            ])
            ->actions([
                Action::make('edit item')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->url(fn (Item $record): string => route('filament.admin.resources.items.edit', $record)),
            ]);
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
