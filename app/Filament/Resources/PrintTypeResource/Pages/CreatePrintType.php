<?php

namespace App\Filament\Resources\PrintTypeResource\Pages;

use App\Filament\Resources\PrintTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePrintType extends CreateRecord
{
    protected static string $resource = PrintTypeResource::class;

    // redirect to back to list on save instead of edit page
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
