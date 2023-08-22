<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\PrintType;
use App\Models\Supplier;
use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class OverviewCount extends BaseWidget
{
    protected function getCards(): array
    {
        $suppliersCount = Supplier::all()->count();
        $categoriesCount = Category::all()->count();
        $printTypesCount = PrintType::all()->count();
        $tagsCount = Tag::all()->count();

        return [
            Card::make('Suppliers', $suppliersCount),
            Card::make('Categories', $categoriesCount),
            Card::make('Print Types', $printTypesCount),
            Card::make('Tags', $tagsCount),
        ];
    }
}
