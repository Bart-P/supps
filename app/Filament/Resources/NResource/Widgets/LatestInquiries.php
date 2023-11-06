<?php

namespace App\Filament\Resources\NResource\Widgets;

use App\Models\Inquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiries extends BaseWidget
{
    // protected int | string | array $columnSpan = 'full';
    // TODO create latest projects Widget - same as here, just for projects

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->recordUrl(
                fn (Inquiry $record) => route('filament.admin.resources.inquiries.manage', $record->id)
            )
            ->query(
                Inquiry::query()->latest()->take(10)
            )
            ->columns([
                TextColumn::make('project.ext_id')
                    ->label('Project'),
                TextColumn::make('name'),
                TextColumn::make('created_at'),
            ]);
    }
}
