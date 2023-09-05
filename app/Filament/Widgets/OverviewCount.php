<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\PrintType;
use App\Models\Supplier;
use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewCount extends BaseWidget
{
    protected function getCards(): array
    {
        $suppliersCount = Supplier::all()->count();
        $categoriesCount = Category::all()->count();
        $printTypesCount = PrintType::all()->count();
        $tagsCount = Tag::all()->count();

        return [
            Stat::make('Suppliers', $suppliersCount)
                ->color('primary'),
            Stat::make('Categories', $categoriesCount)
                ->color('success'),
            Stat::make('Print Types', $printTypesCount),
            Stat::make('Tags', $tagsCount),
        ];
    }
}
