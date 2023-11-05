<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
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
            // TODO -> update relation to query with joins for product and category names
            ->relationship(fn () => Inquiry::find($this->inquiry_id)->items())
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('updated_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                TextColumn::make('created_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
            ])
            ->actions([
                // TODO -> implement CRUD for items in custom component
            ]);
    }


    public function render()
    {
        return view('livewire.list-items');
    }
}
