<?php

namespace App\Filament\Resources\NResource\Widgets;

use App\Models\Inquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiries extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inquiry::query()
            )
            ->columns([
                TextColumn::make('project_id'),
                TextColumn::make('name')
            ]);
    }
}
